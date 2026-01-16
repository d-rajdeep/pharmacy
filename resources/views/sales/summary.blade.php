@extends('layouts.app')

@section('content')
    <div class="page-wrapper">

        <div class="page-breadcrumb">
            <h3 class="page-title">Sales Summary (Customer Wise)</h3>
        </div>

        {{-- Filters --}}
        <div class="container mb-3">
            <div class="card shadow-sm p-3" style="border-radius:15px;">
                <form method="GET" class="row g-3">

                    <div class="col-md-3">
                        <input type="date" name="date" value="{{ request('date') }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <input type="month" name="month" value="{{ request('month') }}" class="form-control">
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.sales.summary') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>

                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. No</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Total Bills</th>
                                <th>Date</th>
                                <th>Total Sales (₹)</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->customer_name ?? 'Walk-in' }}</td>
                                    <td>{{ $sale->customer_phone ?? '-' }}</td>
                                    <td>{{ $sale->total_bills }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->last_bill_date)->format('d-m-Y') }}</td>
                                    <td class="fw-bold text-success">
                                        ₹{{ number_format($sale->total_sales, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        No sales found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end">
                        {{ $sales->links() }}
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
