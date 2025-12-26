<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\StockAdjustment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InventoryController extends Controller
{
    // Inventory Summary
    public function summary()
    {
        return view('inventory.summary', [
            'totalMedicines' => Medicine::count(),
            'totalStock' => Medicine::sum('quantity'),
            'lowStock' => Medicine::whereBetween('quantity', [1, 10])->count(),
            'outOfStock' => Medicine::where('quantity', 0)->count(),
            'totalValue' => Medicine::sum(DB::raw('quantity * price')),
        ]);
    }

    // Adjust Stock Form
    public function adjustForm($id)
    {
        $medicine = Medicine::findOrFail($id);
        return view('inventory.adjust-stock', compact('medicine'));
    }

    // Adjust Stock Logic
    public function adjustStock(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        $medicine = Medicine::findOrFail($id);

        if ($request->type === 'out' && $medicine->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock']);
        }

        $medicine->quantity += $request->type === 'in'
            ? $request->quantity
            : -$request->quantity;

        $medicine->save();

        StockAdjustment::create([
            'medicine_id' => $medicine->id,
            'type' => $request->type,
            'quantity' => $request->quantity,
            'reason' => $request->reason,
        ]);

        return redirect()->route('admin.medicines.index')
            ->with('success', 'Stock adjusted successfully');
    }
}
