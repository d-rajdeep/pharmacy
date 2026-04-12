@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-12">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Customers Directory</h3>
                    <p class="text-muted mb-0">View and manage your pharmacy's customer base.</p>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 20px; overflow: hidden;">

                {{-- Optional Header (Makes the card look complete) --}}
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="mb-0 fw-bold text-dark">All Customers</h5>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted fw-semibold" width="80">#</th>
                                <th class="py-3 text-muted fw-semibold">Customer Name</th>
                                <th class="py-3 text-muted fw-semibold">Phone Number</th>
                                <th class="py-3 text-muted fw-semibold">Last Purchase</th>
                            </tr>
                        </thead>
                        <tbody class="border-top-0">
                            @forelse($customers as $customer)
                                <tr>
                                    <td class="ps-4 text-muted fw-medium">
                                        {{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}
                                    </td>

                                    <td>
                                        <div class="fw-bold text-dark d-flex align-items-center">
                                            {{-- Dynamic Avatar Circle --}}
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center me-3 fw-bold"
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

                                    <td>
                                        <div class="text-dark fw-medium">
                                            <i class="fas fa-calendar-alt text-muted me-2 opacity-50"
                                                style="font-size: 0.85rem;"></i>{{ \Carbon\Carbon::parse($customer->last_purchase)->format('d M Y') }}
                                        </div>
                                        <div class="text-muted small" style="margin-left: 26px;">
                                            {{ \Carbon\Carbon::parse($customer->last_purchase)->format('h:i A') }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <div class="bg-light rounded-circle d-inline-flex p-4 mb-3">
                                            <i class="fas fa-users fa-2x text-secondary opacity-50"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">No customers found</h5>
                                        <p class="mb-0">Customers will appear here automatically when you generate bills.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Clean Footer Pagination --}}
                @if ($customers->hasPages())
                    <div class="card-footer bg-white border-top py-3 px-4">
                        <div class="d-flex justify-content-end m-0">
                            {{ $customers->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                @endif

            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
