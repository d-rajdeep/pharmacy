@extends('layouts.app')

@section('content')
    <div class="page-wrapper bg-light">
        <div class="page-breadcrumb pb-3">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-bold mb-0">Sales & Invoices</h3>
                    <p class="text-muted mb-0">Manage your generated bills and view sales summaries.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid">

            {{-- Success/Error Alerts for Deletion --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- FILTER SECTION --}}
            <div class="card mb-4 shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body bg-white rounded-3">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted text-uppercase fs-7">From Date</label>
                            <input type="date" name="from" value="{{ $from }}"
                                class="form-control shadow-sm border-0 bg-light">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted text-uppercase fs-7">To Date</label>
                            <input type="date" name="to" value="{{ $to }}"
                                class="form-control shadow-sm border-0 bg-light">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary shadow-sm px-4">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary shadow-sm px-4">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SUMMARY CARDS --}}
            <div class="row mb-4 g-3">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                        <div class="card-body text-center py-4">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex p-3 mb-2">
                                <i class="fas fa-wallet fa-2x"></i>
                            </div>
                            <h6 class="text-muted fw-semibold">Filtered Sales Total</h6>
                            <h3 class="text-success fw-bold mb-0">₹ {{ number_format($todayTotal, 2) }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                        <div class="card-body text-center py-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex p-3 mb-2">
                                <i class="fas fa-file-invoice fa-2x"></i>
                            </div>
                            <h6 class="text-muted fw-semibold">Filtered Bills Count</h6>
                            <h3 class="text-dark fw-bold mb-0">{{ $todayBills }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 15px;">
                        <div class="card-body text-center py-4">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex p-3 mb-2">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h6 class="text-muted fw-semibold">Unique Customers</h6>
                            <h3 class="text-dark fw-bold mb-0">{{ $todayCustomers }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SALES / INVOICES TABLE --}}
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Invoice No</th>
                                    <th>Customer Info</th>
                                    <th>Total Amount</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th class="text-center pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $bill)
                                    <tr>
                                        <td class="ps-4 fw-bold text-primary">{{ $bill->invoice_no }}</td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $bill->customer_name }}</div>
                                            <div class="text-muted small"><i
                                                    class="fas fa-phone-alt me-1"></i>{{ $bill->customer_phone }}</div>
                                        </td>
                                        <td class="fw-bold text-success">₹{{ number_format($bill->total, 2) }}</td>
                                        <td>{{ $bill->created_at->format('d M Y') }}</td>
                                        <td>{{ $bill->created_at->format('h:i A') }}</td>
                                        <td class="text-center pe-4">
                                            <div class="btn-group shadow-sm">
                                                <a href="{{ route('admin.billing.show', $bill) }}"
                                                    class="btn btn-sm btn-outline-primary" title="View Invoice">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.billing.download', $bill) }}"
                                                    class="btn btn-sm btn-outline-success" title="Print Invoice">
                                                    <i class="fas fa-print"></i>
                                                </a>
                                                <form action="{{ route('admin.billing.delete', $bill) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this bill? This will restore the inventory stock.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        title="Delete Invoice">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-receipt fa-3x mb-3 d-block text-light"></i>
                                            No sales found for the selected dates.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 py-3">
                    <div class="d-flex justify-content-end">
                        {{ $sales->links() }}
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
