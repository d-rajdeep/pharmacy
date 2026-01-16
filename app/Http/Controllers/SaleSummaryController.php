<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleSummaryController extends Controller
{
    public function index(Request $request)
    {
        /* ===============================
         | CUSTOMER WISE SALES SUMMARY
         =============================== */
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


        /* ===============================
         | DAILY SALES (TODAY)
         =============================== */
        $dailySales = Bill::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
            ->whereDate('created_at', today())
            ->groupBy('date')
            ->get();


        /* ===============================
         | WEEKLY SALES (LAST 7 DAYS)
         =============================== */
        $weeklySales = Bill::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('SUM(total) as total')
        )
            ->whereBetween('created_at', [
                Carbon::now()->subDays(6)->startOfDay(),
                Carbon::now()->endOfDay()
            ])
            ->groupBy('date')
            ->orderBy('date')
            ->get();


        /* ===============================
         | MONTHLY SALES (CURRENT YEAR)
         =============================== */
        $monthlySales = Bill::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        return view('sales.summary', compact(
            'sales',
            'dailySales',
            'weeklySales',
            'monthlySales'
        ));
    }

    public function customers()
    {
        $customers = Bill::select(
            'customer_name',
            'customer_phone',
            DB::raw('COUNT(*) as total_bills'),
            DB::raw('SUM(total) as total_spent')
        )
            ->groupBy('customer_name', 'customer_phone')
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }

    public function customerBills($phone)
    {
        $bills = Bill::where('customer_phone', $phone)
            ->latest()
            ->paginate(10);

        $customer = $bills->first();

        return view('customers.bills', compact('bills', 'customer'));
    }
}
