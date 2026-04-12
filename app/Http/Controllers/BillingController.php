<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Medicine;
use App\Models\StockAdjustment;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BillingController extends Controller
{
    public function index()
    {
        $bills = Bill::latest()->paginate(10);
        return view('billing.index', compact('bills'));
    }

    public function create()
    {
        $medicines = Medicine::where('quantity', '>', 0)->get();
        return view('billing.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|numeric|digits:10',
            'items' => 'required|array',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.type' => 'required|in:strip,tablet',
            'payment_status' => 'required|in:paid,pending',
        ], [
            'customer_phone.digits' => 'The phone number must be exactly 10 digits.',
            'items.required' => 'You must add at least one medicine to the bill.',
        ]);

        try {
            $bill = DB::transaction(function () use ($request) {
                $subtotal = 0;

                // First pass: Calculate subtotal & Check Expiry
                foreach ($request->items as $item) {
                    $medicine = Medicine::findOrFail($item['medicine_id']);

                    // --- NEW EXPIRY CHECK ---
                    if ($medicine->expiry_date && \Carbon\Carbon::parse($medicine->expiry_date)->endOfDay()->isPast()) {
                        $formattedDate = \Carbon\Carbon::parse($medicine->expiry_date)->format('d-m-Y');
                        throw new \Exception("Cannot sell '{$medicine->name}'. It expired on {$formattedDate}.");
                    }
                    // ------------------------

                    $unitPrice = $item['type'] === 'tablet'
                        ? ($medicine->mrp / $medicine->tablets_per_strip)
                        : $medicine->mrp;

                    $subtotal += $unitPrice * $item['quantity'];
                }

                $discountPercent = $request->discount ?? 0;
                $discountAmount = ($subtotal * $discountPercent) / 100;
                $tax = $request->tax ?? 0;

                $newBill = Bill::create([
                    'invoice_no' => 'INV-' . now()->format('YmdHis'),
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'subtotal' => $subtotal,
                    'discount' => $discountPercent,
                    'tax' => $tax,
                    'total' => $subtotal - $discountAmount + $tax,
                    'payment_status' => $request->payment_status,
                ]);

                foreach ($request->items as $item) {
                    $medicine = Medicine::findOrFail($item['medicine_id']);

                    $unitPrice = $item['type'] === 'tablet'
                        ? ($medicine->mrp / $medicine->tablets_per_strip)
                        : $medicine->mrp;

                    $stockToDeduct = $item['type'] === 'tablet'
                        ? ($item['quantity'] / $medicine->tablets_per_strip)
                        : $item['quantity'];

                    if ($medicine->quantity < $stockToDeduct) {
                        throw new \Exception("Insufficient stock for {$medicine->name}");
                    }

                    $medicine->decrement('quantity', $stockToDeduct);

                    BillItem::create([
                        'bill_id' => $newBill->id,
                        'medicine_id' => $medicine->id,
                        'quantity' => $item['quantity'],
                        'price' => $unitPrice,
                        'total' => $unitPrice * $item['quantity'],
                    ]);

                    StockAdjustment::create([
                        'medicine_id' => $medicine->id,
                        'type' => 'out',
                        'quantity' => $stockToDeduct,
                        'reason' => 'Sale (' . ucfirst($item['type']) . ') - Invoice ' . $newBill->invoice_no,
                    ]);
                }

                return $newBill;
            });

            return redirect()->route('admin.billing.show', $bill->id)
                ->with('success', 'Bill generated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function searchMedicine(Request $request)
    {
        $query = $request->q;
        $today = now()->toDateString();

        $medicines = Medicine::where('name', 'LIKE', "%{$query}%")
            ->where('quantity', '>', 0)
            ->where(function ($q) use ($today) {
                $q->whereNull('expiry_date')
                    ->orWhere('expiry_date', '>=', $today);
            })
            ->limit(10)
            ->get(['id', 'name', 'mrp', 'quantity', 'tablets_per_strip', 'description']);

        return response()->json($medicines);
    }

    public function downloadPDF(Bill $bill)
    {
        $bill->load('items.medicine');
        $pdf = Pdf::loadView('billing.pdf', compact('bill'));
        return $pdf->stream('Invoice-' . $bill->invoice_no . '.pdf');
    }

    public function show(Bill $bill)
    {
        $bill->load('items.medicine');
        return view('billing.show', compact('bill'));
    }

    public function destroy(Bill $bill)
    {
        DB::transaction(function () use ($bill) {
            foreach ($bill->items as $item) {
                $medicine = Medicine::find($item->medicine_id);
                if ($medicine) {
                    $medicine->increment('quantity', $item->quantity);
                }
            }
            $bill->items()->delete();
            $bill->delete();
        });

        return redirect()->back()->with('success', 'Bill deleted successfully');
    }
}
