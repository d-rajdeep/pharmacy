<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Bill::select(
            'customer_name',
            'customer_phone',
            DB::raw('MAX(created_at) as last_purchase')
        )
            ->groupBy('customer_name', 'customer_phone')
            ->orderByDesc('last_purchase')
            ->paginate(15);

        return view('customers.index', compact('customers'));
    }
}
