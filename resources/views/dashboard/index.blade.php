@extends('layouts.app')

@section('content')
    <style>
        /* Custom Dashboard Animations & Styles */
        .hover-elevate {
            transition: all 0.3s ease-in-out;
            border-radius: 20px;
        }

        .hover-elevate:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 16px;
            font-size: 24px;
        }

        .clickable-card {
            text-decoration: none !important;
            color: inherit;
            display: block;
        }

        /* Pulse animation for expiring alert */
        @keyframes pulse-red {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        .pulse-alert:hover .icon-box {
            animation: pulse-red 1.5s infinite;
        }

        /* Floating Live Alert Styles */
        .floating-alert {
            position: fixed;
            bottom: 30px;
            /* Adjust this left value if it overlaps your sidebar (Sidebar is usually ~250px) */
            right: 30px;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #dc3545, #ff4b2b);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
            z-index: 1050;
            text-decoration: none;
            transition: transform 0.3s ease;
            animation: pulse-danger 1.5s infinite;
        }

        .floating-alert:hover {
            color: white;
            transform: scale(1.1);
            animation: none;
            /* Pauses the pulse when you hover */
        }

        @keyframes pulse-danger {
            0% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
            }

            70% {
                box-shadow: 0 0 0 20px rgba(220, 53, 69, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
            }
        }

        /* Fixes the red badge to the top right of the bell */
        .floating-badge {
            position: absolute;
            top: -2px;
            right: -2px;
            font-size: 11px;
            border: 2px solid white;
        }
    </style>

    <div class="page-wrapper bg-light">
        <div class="page-breadcrumb pb-4">
            <div class="row align-items-center">
                <div class="col-md-6 col-12 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-bold mb-1">Admin Dashboard</h3>
                    <p class="text-muted mb-0">Welcome back, Admin! Here is your summary.</p>
                </div>
                <div class="col-md-6 col-12 align-self-center mt-3 mt-md-0 d-flex justify-content-md-end">
                    <div id="datetime-box" class="bg-white shadow-sm px-4 py-2 text-center fw-bold text-primary"
                        style="border-radius: 12px; border: 1px solid #eef2f6;">
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row g-4 mb-4">

                {{-- Total Inventory Value --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 hover-elevate h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-success bg-opacity-10 text-success me-3">
                                <i class="fas fa-rupee-sign fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1">Total Inventory Value</h6>
                                <h3 class="fw-bold mb-0 text-dark">₹ {{ number_format($totalValue, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Medicines --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 hover-elevate h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-primary bg-opacity-10 text-primary me-3">
                                <i class="fas fa-pills fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1">Total Medicine</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalMedicines }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Total Stock --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 hover-elevate h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-info bg-opacity-10 text-info me-3">
                                <i class="fas fa-boxes fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1">Total Stock (Unit)</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $totalStock }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Low Stock --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 hover-elevate h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning me-3">
                                <i class="fas fa-exclamation-triangle fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1">Low Stock Alerts</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $lowStock }} <small
                                        class="text-muted fs-6 fw-normal">(< 10 qty)</small>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Out of Stock --}}
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-sm border-0 hover-elevate h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="icon-box bg-dark bg-opacity-10 text-dark me-3">
                                <i class="fas fa-times-circle fa-lg"></i>
                            </div>
                            <div>
                                <h6 class="text-muted fw-semibold mb-1">Out of Stock</h6>
                                <h3 class="fw-bold mb-0 text-dark">{{ $outOfStock }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Expiring Soon (CLICKABLE) --}}
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('admin.dashboard.expiring') }}" class="clickable-card h-100">
                        <div class="card shadow-sm border-0 hover-elevate pulse-alert h-100"
                            style="border-left: 5px solid #dc3545 !important;">
                            <div class="card-body d-flex align-items-center">
                                <div class="icon-box bg-danger bg-opacity-10 text-danger me-3">
                                    <i class="fas fa-calendar-times fa-lg"></i>
                                </div>
                                <div>
                                    <h6 class="text-danger fw-bold mb-1">Expiring Soon (2 Months)</h6>
                                    <h3 class="fw-bold mb-0 text-dark">{{ $expiringSoonCount }} <small
                                            class="text-muted fs-6 fw-normal">items</small></h3>
                                    <small class="text-primary fw-semibold mt-1 d-block">Click to view list <i
                                            class="fas fa-arrow-right ms-1"></i></small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div
                            class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold mb-0"><i class="fas fa-shopping-cart text-primary me-2"></i>Recent Sales</h5>
                        </div>
                        <div class="card-body px-4">

                            <form method="GET" class="row g-3 align-items-end mb-4 bg-light p-3 rounded-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted text-uppercase fs-7">Filter by
                                        Date</label>
                                    <input type="date" name="date" class="form-control border-0 shadow-sm"
                                        value="{{ request('date') }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold text-muted text-uppercase fs-7">Filter by
                                        Month</label>
                                    <input type="month" name="month" class="form-control border-0 shadow-sm"
                                        value="{{ request('month') }}">
                                </div>
                                <div class="col-md-4 d-flex gap-2">
                                    <button class="btn btn-primary shadow-sm flex-grow-1"><i class="fas fa-filter me-1"></i>
                                        Filter</button>
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="btn btn-light shadow-sm flex-grow-1 text-dark">Clear</a>
                                </div>
                            </form>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle border">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Bill No</th>
                                            <th>Customer Name</th>
                                            <th>Total Amount</th>
                                            <th>Date Generated</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($bills as $bill)
                                            <tr>
                                                <td class="fw-semibold text-primary">{{ $bill->invoice_no }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-light rounded-circle p-2 me-2 text-secondary"><i
                                                                class="fas fa-user"></i></div>
                                                        {{ $bill->customer_name }}
                                                    </div>
                                                </td>
                                                <td class="fw-bold text-success">₹{{ number_format($bill->total, 2) }}</td>
                                                <td class="text-muted">{{ $bill->created_at->format('d M Y, h:i A') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.billing.show', $bill->id) }}"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">No sales found for
                                                    the selected criteria.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end mt-3">
                                {{ $bills->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>
    @if ($expiringSoonCount > 0)
        <a href="{{ route('admin.dashboard.expiring') }}" class="floating-alert" title="Medicines Expiring Soon!">
            <i class="fas fa-bell"></i>
            <span class="badge rounded-pill bg-danger floating-badge">
                {{ $expiringSoonCount }}
            </span>
        </a>
    @endif
    <script>
        function updateDateTime() {
            const now = new Date();
            const options = {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
            document.getElementById('datetime-box').textContent = now.toLocaleString('en-US', options).replace(',', '');
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
@endsection
