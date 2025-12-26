@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="page-wrapper">
                    <div class="container-fluid">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Invoice</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bill->invoice_no }}</td>
                                        <td>{{ $bill->customer_name }}</td>
                                        <td>{{ $bill->customer_phone }}</td>
                                        <td>₹{{ $bill->total }}</td>
                                        <td>{{ $bill->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.billing.show', $bill) }}" class="btn btn-sm btn-primary">
                                                View
                                            </a>
                                            <a href="{{ route('admin.billing.download', $bill) }}"
                                                class="btn btn-sm btn-success">
                                                Print
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
