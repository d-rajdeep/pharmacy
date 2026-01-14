@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container">
            <div class="card shadow-sm p-4" style="border-radius:20px;">
                <h3 class="mb-4">All Purchases</h3>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl. No</th>
                            <th>Invoice</th>
                            <th>Customer</th>
                            <th>Phone</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Action</th>
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
                                    <a href="{{ route('admin.billing.download', $bill) }}" class="btn btn-sm btn-success">
                                        Print
                                    </a>
                                    <form action="{{ route('admin.billing.delete', $bill) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
