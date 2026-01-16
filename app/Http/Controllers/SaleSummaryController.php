<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleSummaryController extends Controller
{
    public function index(Request $request)
    {
        $sales = Bill::select(
            'customer_name',
            'customer_phone',
            DB::raw('SUM(total) as total_sales'),
            DB::raw('COUNT(id) as total_bills'),
            DB::raw('MAX(created_at) as last_bill_date')
        )
            ->when($request->date, function ($q) use ($request) {
                $q->whereDate('created_at', $request->date);
            })
            ->when($request->month, function ($q) use ($request) {
                $q->whereMonth('created_at', date('m', strtotime($request->month)))
                    ->whereYear('created_at', date('Y', strtotime($request->month)));
            })
            ->groupBy('customer_name', 'customer_phone')
            ->orderByDesc('total_sales')
            ->paginate(10)
            ->withQueryString();

        return view('sales.summary', compact('sales'));
    }
}
