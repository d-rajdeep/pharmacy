@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Today's Sales</h3>
                </div><br></br>
                {{-- FILTER --}}
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">

                        <form method="GET" class="row g-3 align-items-end">

                            <div class="col-md-3">
                                <label>From Date</label>
                                <input type="date" name="from" value="{{ $from }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <label>To Date</label>
                                <input type="date" name="to" value="{{ $to }}" class="form-control">
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary">
                                    Filter
                                </button>

                                <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

                {{-- SUMMARY CARDS --}}
                <div class="row mb-4">

                    <div class="col-md-4">
                        <div class="card shadow text-center p-3">
                            <h6>Total Sales</h6>
                            <h4 class="text-success">₹ {{ number_format($todayTotal, 2) }}</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow text-center p-3">
                            <h6>Total Bills</h6>
                            <h4>{{ $todayBills }}</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow text-center p-3">
                            <h6>Total Customers</h6>
                            <h4>{{ $todayCustomers }}</h4>
                        </div>
                    </div>

                </div>


                {{-- SALES TABLE --}}
                <div class="card shadow">
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Product</th>
                                    <th>Customer</th>
                                    <th>Phone</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($sales as $bill)
                                    @foreach ($bill->items as $item)
                                        <tr>
                                            <td>{{ $bill->created_at->format('d-m-Y H:i') }}</td>
                                            <td>{{ $item->medicine->name ?? '-' }}</td>
                                            <td>{{ $bill->customer_name }}</td>
                                            <td>{{ $bill->customer_phone }}</td>
                                            <td>₹ {{ $item->total }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach

                            </tbody>
                        </table>

                        {{ $sales->links() }}

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
