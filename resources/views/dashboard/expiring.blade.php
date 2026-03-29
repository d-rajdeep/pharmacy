@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb pb-3">
            <div class="row align-items-center">
                <div class="col-md-6 col-12 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-bold mb-1">
                        <i class="fas fa-calendar-times text-danger me-2"></i> Medicines Expiring Soon
                    </h3>
                    <p class="text-muted mb-0">List of medicines expiring within the next 2 months.</p>
                </div>
                <div class="col-md-6 col-12 align-self-center d-flex justify-content-md-end mt-3 mt-md-0">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-pill shadow-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm border-0" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover border align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Category</th>
                                    <th>Current Stock</th>
                                    <th>Expiry Date</th>
                                    <th>Days Left</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicines as $medicine)
                                    @php
                                        $expiryDate = \Carbon\Carbon::parse($medicine->expiry_date);
                                        $daysLeft = now()->diffInDays($expiryDate, false);
                                    @endphp
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $medicine->name }}</td>
                                        <td class="text-muted">{{ $medicine->category->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge bg-primary rounded-pill px-3">{{ $medicine->quantity }}
                                                Strips</span>
                                        </td>
                                        <td class="fw-semibold {{ $daysLeft <= 15 ? 'text-danger' : 'text-warning' }}">
                                            {{ $expiryDate->format('d M Y') }}
                                        </td>
                                        <td>
                                            @if ($daysLeft < 0)
                                                <span class="badge bg-danger">Expired</span>
                                            @else
                                                <span
                                                    class="badge {{ $daysLeft <= 15 ? 'bg-danger' : 'bg-warning text-dark' }}">
                                                    {{ ceil($daysLeft) }} Days
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.medicines.edit', $medicine->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                Update Stock
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="fas fa-check-circle text-success fa-3x mb-3 d-block"></i>
                                            Great! No medicines are expiring in the next 2 months.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $medicines->links() }}
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
