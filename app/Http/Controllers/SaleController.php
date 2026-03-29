<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Request;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | Date Filters
    |--------------------------------------------------------------------------
    */

        $from = $request->from ?? now()->toDateString();
        $to   = $request->to ?? now()->toDateString();


        /*
    |--------------------------------------------------------------------------
    | Base Query
    |--------------------------------------------------------------------------
    */

        $query = Bill::with('items.medicine')
            ->whereBetween('created_at', [
                $from . ' 00:00:00',
                $to   . ' 23:59:59'
            ]);


        /*
    |--------------------------------------------------------------------------
    | Summary
    |--------------------------------------------------------------------------
    */

        $todayTotal = (clone $query)->sum('total');

        $todayBills = (clone $query)->count();

        $todayCustomers = (clone $query)
            ->distinct('customer_phone')
            ->count('customer_phone');


        /*
    |--------------------------------------------------------------------------
    | Table Data
    |--------------------------------------------------------------------------
    */

        $sales = $query
            ->latest()
            ->paginate(5)
            ->withQueryString(); // keep filters on pagination


        return view('sales.index', compact(
            'sales',
            'todayTotal',
            'todayBills',
            'todayCustomers',
            'from',
            'to'
        ));
    }
}
