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
            'items' => 'required|array',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                $subtotal = 0;

                // First pass: Calculate subtotal
                foreach ($request->items as $item) {
                    $medicine = Medicine::findOrFail($item['medicine_id']);
                    $subtotal += $medicine->price * $item['quantity'];
                }

                $discountPercent = $request->discount ?? 0;
                $discountAmount = ($subtotal * $discountPercent) / 100;
                $tax = $request->tax ?? 0;

                $bill = Bill::create([
                    'invoice_no' => 'INV-' . now()->format('YmdHis'),
                    'customer_name' => $request->customer_name,
                    'customer_phone' => $request->customer_phone,
                    'subtotal' => $subtotal,
                    'discount' => $discountPercent,
                    'tax' => $tax,
                    'total' => $subtotal - $discountAmount + $tax,
                ]);

                foreach ($request->items as $item) {
                    $medicine = Medicine::findOrFail($item['medicine_id']);

                    if ($medicine->quantity < $item['quantity']) {
                        throw new \Exception("Insufficient stock for {$medicine->name}");
                    }

                    $medicine->decrement('quantity', $item['quantity']);

                    BillItem::create([
                        'bill_id' => $bill->id,
                        'medicine_id' => $medicine->id,
                        'quantity' => $item['quantity'],
                        'price' => $medicine->price,
                        'total' => $medicine->price * $item['quantity'],
                    ]);

                    // Optional: Stock Adjustment record
                    StockAdjustment::create([
                        'medicine_id' => $medicine->id,
                        'type' => 'out',
                        'quantity' => $item['quantity'],
                        'reason' => 'Sale - Invoice ' . $bill->invoice_no,
                    ]);
                }
            });

            return redirect()->route('admin.billing.index')->with('success', 'Bill generated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function searchMedicine(Request $request)
    {
        $query = $request->q;

        $medicines = Medicine::where('name', 'LIKE', "%{$query}%")
            ->where('quantity', '>', 0)
            ->limit(10)
            ->get(['id', 'name', 'price', 'quantity']);

        return response()->json($medicines);
    }

    public function downloadPDF(Bill $bill)
    {
        $bill->load('items.medicine');

        // This points to resources/views/billing/pdf.blade.php
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

            // Restore stock for each bill item
            foreach ($bill->items as $item) {
                $medicine = Medicine::find($item->medicine_id);

                if ($medicine) {
                    $medicine->increment('quantity', $item->quantity);

                    // Optional: record stock rollback
                    StockAdjustment::create([
                        'medicine_id' => $medicine->id,
                        'type' => 'in',
                        'quantity' => $item->quantity,
                        'reason' => 'Bill deleted - ' . $bill->invoice_no,
                    ]);
                }
            }

            // Delete bill items first
            $bill->items()->delete();

            // Delete bill
            $bill->delete();
        });

        return redirect()->back()->with('success', 'Bill deleted successfully');
    }
}
