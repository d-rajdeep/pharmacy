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
                <h6 class="text-end">Discount (%):-{{ number_format($bill->discount, 2) }}</h6>
                <h4 class="text-end">Grand Total: ₹{{ $bill->total }}</h4>
                <td class="text-end">
                    <div class="d-flex gap-2 justify-content-end">

                        <a href="{{ route('admin.billing.download', $bill) }}" class="btn btn-sm btn-outline-success px-3">
                            <i class="fas fa-print me-1"></i> Print
                        </a>

                        <a href="{{ route('admin.billing.index') }}" class="btn btn-sm btn-outline-primary px-3">
                            <i class="fas fa-arrow-left me-1"></i> Back
                        </a>

                    </div>
                </td>

            </div>
        </div>
    </div>
@endsection
