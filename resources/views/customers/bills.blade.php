@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3>
                    {{ $customer->customer_name }}
                    <small class="text-muted">({{ $customer->customer_phone }})</small>
                </h3>

                <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

            <div class="card mb-3 p-3">
                <strong>Total Purchase:</strong>
                ₹{{ number_format($totalAmount, 2) }}
            </div>

            <!-- Filter -->
            <form method="GET" class="row mb-3">
                <div class="col-md-3">
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>
                <div class="col-md-2">
                    <button class="btn btn-primary">Filter</button>
                </div>
            </form>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. No</th>
                                <th>Invoice</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bills as $bill)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bill->invoice_no }}</td>
                                    <td>{{ $bill->created_at->format('d M Y') }}</td>
                                    <td>₹{{ number_format($bill->total, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.billing.show', $bill->id) }}"
                                            class="btn btn-sm btn-success">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $bills->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
