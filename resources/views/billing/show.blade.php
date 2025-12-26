@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container">
            <div class="card shadow-sm p-4">
                <h4>Invoice #{{ $bill->id }}</h4>
                <p><strong>Customer:</strong> {{ $bill->customer_name }}</p>

                <table class="table mt-3">
                    <tr>
                        <th>Medicine</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>

                    @foreach ($bill->items as $item)
                        <tr>
                            <td>{{ $item->medicine->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>₹{{ $item->price }}</td>
                            <td>₹{{ $item->total }}</td>
                        </tr>
                    @endforeach
                </table>

                <h5 class="text-end">Grand Total: ₹{{ $bill->total_amount }}</h5>
            </div>
        </div>
    </div>
@endsection
