@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">

            <h3 class="mb-4">Customers</h3>

            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Sl. No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Total Bills</th>
                                <th>Total Sales</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->customer_phone }}</td>
                                    <td>{{ $customer->total_bills }}</td>
                                    <td>₹{{ number_format($customer->total_spent, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.customers.bills', $customer->customer_phone) }}"
                                            class="btn btn-sm btn-primary">
                                            View Bills
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-3">
                    {{ $customers->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection
