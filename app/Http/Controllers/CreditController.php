<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditController extends Controller
{
    public function index()
    {
        // Group pending bills by customer phone number to show total outstanding
        $creditCustomers = Bill::where('payment_status', 'pending')
            ->select(
                'customer_name',
                'customer_phone',
                DB::raw('SUM(total) as total_due'),
                DB::raw('COUNT(id) as unpaid_bills_count')
            )
            ->groupBy('customer_name', 'customer_phone')
            ->orderBy('total_due', 'desc')
            ->get();

        return view('credit.index', compact('creditCustomers'));
    }

    // Optional: A method to mark a specific customer's bills as paid
    public function markAsPaid($phone)
    {
        Bill::where('customer_phone', $phone)
            ->where('payment_status', 'pending')
            ->update(['payment_status' => 'paid']);

        return back()->with('success', 'Customer dues cleared successfully!');
    }
}
