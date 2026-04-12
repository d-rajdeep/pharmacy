@extends('layouts.app')
@section('title', 'Credit Customers')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-12">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Credit Customers (Khata)</h3>
                    <p class="text-muted mb-0">Track pending payments and clear outstanding dues.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">

            {{-- Success/Error Alerts --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-3" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px; overflow: hidden;">

                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="mb-0 fw-bold text-dark">Pending Dues Overview</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted fw-semibold">Customer Name</th>
                                <th class="py-3 text-muted fw-semibold">Phone Number</th>
                                <th class="py-3 text-muted fw-semibold text-center">Pending Bills</th>
                                <th class="py-3 text-muted fw-semibold">Total Amount Due</th>
                                <th class="pe-4 py-3 text-muted fw-semibold text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($creditCustomers as $customer)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark d-flex align-items-center">
                                            {{-- Dynamic Avatar Circle (Red to indicate dues) --}}
                                            <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-flex justify-content-center align-items-center me-3 fw-bold shadow-sm"
                                                style="width: 40px; height: 40px; font-size: 1.1rem;">
                                                {{ strtoupper(substr($customer->customer_name, 0, 1)) }}
                                            </div>
                                            {{ $customer->customer_name }}
                                        </div>
                                    </td>

                                    <td>
                                        <div class="text-dark fw-medium">
                                            <i class="fas fa-phone-alt text-muted me-2 opacity-50"
                                                style="font-size: 0.85rem;"></i>{{ $customer->customer_phone }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge bg-warning bg-opacity-10 text-warning-emphasis border border-warning border-opacity-25 px-3 py-2 rounded-pill fs-6 shadow-sm">
                                            {{ $customer->unpaid_bills_count }} Bills
                                        </span>
                                    </td>

                                    <td class="text-danger fw-bold fs-5">
                                        ₹{{ number_format($customer->total_due, 2) }}
                                    </td>

                                    <td class="pe-4 text-end">
                                        <form action="{{ route('admin.billing.credit.pay', $customer->customer_phone) }}"
                                            method="POST"
                                            onsubmit="return confirm('Mark all dues for {{ $customer->customer_name }} as paid?');">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-success shadow-sm px-4 fw-bold rounded-pill"
                                                style="padding-top: 0.5rem; padding-bottom: 0.5rem;">
                                                <i class="fas fa-check-circle me-1"></i> Clear Dues
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex p-4 mb-3">
                                            <i class="fas fa-clipboard-check fa-2x text-success opacity-75"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">All Clear!</h5>
                                        <p class="mb-0">You currently have no customers with pending dues.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
