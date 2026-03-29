<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary(Request $request)
    {
        $totalMedicines = Medicine::count();
        $totalStock = Medicine::sum('quantity');
        $lowStock = Medicine::whereBetween('quantity', [1, 10])->count();
        $outOfStock = Medicine::where('quantity', 0)->count();
        $totalValue = Medicine::sum(DB::raw('quantity * mrp'));

        // Count medicines expiring in the next 2 months
        $expiringSoonCount = Medicine::whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addMonths(2)])
            ->count();

        // Purchases / Bills
        $bills = Bill::query()
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date);
            })
            ->when($request->month, function ($q) use ($request) {
                $q->whereMonth('created_at', date('m', strtotime($request->month)))
                    ->whereYear('created_at', date('Y', strtotime($request->month)));
            })
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('dashboard.index', compact(
            'totalMedicines',
            'totalStock',
            'lowStock',
            'outOfStock',
            'totalValue',
            'expiringSoonCount',
            'bills'
        ));
    }

    // New method for the detailed expiring medicines page
    public function expiringSoon()
    {
        $medicines = Medicine::with('category')
            ->whereNotNull('expiry_date')
            ->whereBetween('expiry_date', [now(), now()->addMonths(2)])
            ->orderBy('expiry_date', 'asc')
            ->paginate(15);

        return view('dashboard.expiring', compact('medicines'));
    }
}
