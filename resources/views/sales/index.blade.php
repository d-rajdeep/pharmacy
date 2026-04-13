@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-12">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Sales & Invoices</h3>
                    <p class="text-muted mb-0">Manage your generated bills and view sales summaries.</p>
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

            {{-- FILTER SECTION --}}
            <div class="card mb-4 shadow-sm border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <form method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 0.85rem;">From
                                Date</label>
                            <input type="date" name="from" value="{{ $from }}"
                                class="form-control form-control-lg bg-light border-0">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-muted text-uppercase" style="font-size: 0.85rem;">To
                                Date</label>
                            <input type="date" name="to" value="{{ $to }}"
                                class="form-control form-control-lg bg-light border-0">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button class="btn btn-primary shadow-sm px-4 fw-bold"
                                style="padding-top: 0.6rem; padding-bottom: 0.6rem;">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                            <a href="{{ route('admin.sales.index') }}" class="btn btn-secondary shadow-sm px-4 fw-bold"
                                style="padding-top: 0.6rem; padding-bottom: 0.6rem;">
                                <i class="fas fa-sync-alt me-1"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- SUMMARY CARDS --}}
            <div class="row mb-4 g-4">
                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-wallet fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Filtered
                                    Sales Total</h6>
                                <h3 class="text-success fw-bold mb-0">₹ {{ number_format($todayTotal, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-file-invoice fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Filtered
                                    Bills Count</h6>
                                <h3 class="text-dark fw-bold mb-0">{{ $todayBills }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card shadow-sm border-0 h-100" style="border-radius: 20px;">
                        <div class="card-body d-flex align-items-center p-4">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3"
                                style="width: 60px; height: 60px;">
                                <i class="fas fa-users fs-3"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1 text-uppercase" style="font-size: 0.8rem;">Unique
                                    Customers</h6>
                                <h3 class="text-dark fw-bold mb-0">{{ $todayCustomers }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SALES / INVOICES TABLE --}}
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px; overflow: hidden;">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted fw-semibold">Invoice No</th>
                                <th class="py-3 text-muted fw-semibold">Customer Info</th>
                                <th class="py-3 text-muted fw-semibold">Total Amount</th>
                                <th class="py-3 text-muted fw-semibold">Status</th>
                                <th class="py-3 text-muted fw-semibold">Date & Time</th>
                                <th class="text-center pe-4 py-3 text-muted fw-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse ($sales as $bill)
                                <tr>
                                    <td class="ps-4 fw-bold text-dark">
                                        <i class="fas fa-receipt text-muted me-2 opacity-50"></i>{{ $bill->invoice_no }}
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $bill->customer_name }}</div>
                                        <div class="text-muted small"><i
                                                class="fas fa-phone-alt me-1 opacity-75"></i>{{ $bill->customer_phone }}
                                        </div>
                                    </td>
                                    <td class="fw-bold text-dark fs-5">₹{{ number_format($bill->total, 2) }}</td>
                                    <td>
                                        @if ($bill->payment_status == 'paid')
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill">Paid</span>
                                        @else
                                            <span
                                                class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-1 rounded-pill">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="text-dark fw-medium">{{ $bill->created_at->format('d M Y') }}</div>
                                        <div class="text-muted small">{{ $bill->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="text-center pe-4">
                                        <div class="d-inline-flex gap-1">
                                            <a href="{{ $bill->whatsapp_url }}" target="_blank"
                                                class="btn btn-sm btn-light text-success border shadow-sm"
                                                title="Send to WhatsApp">
                                                <i class="fab fa-whatsapp fs-6"></i>
                                            </a>
                                            <a href="{{ route('admin.billing.show', $bill) }}"
                                                class="btn btn-sm btn-light text-primary border shadow-sm"
                                                title="View Invoice">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.billing.download', $bill) }}"
                                                class="btn btn-sm btn-light text-success border shadow-sm"
                                                title="Print Invoice">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <form action="{{ route('admin.billing.delete', $bill) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this bill? This will restore the inventory stock.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-light text-danger border shadow-sm"
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
                                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                            <i class="fas fa-receipt fa-2x text-secondary opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">No sales found</h5>
                                        <p class="mb-0">Try adjusting your date filters.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($sales->hasPages())
                    <div class="card-footer bg-white border-top py-3 px-4">
                        <div class="d-flex justify-content-end m-0">
                            {{ $sales->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
