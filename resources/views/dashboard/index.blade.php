@extends('layouts.app')
@section('content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-7 align-self-center">
                    <h3 class="page-title text-truncate text-dark font-weight-medium mb-1">Welcome Admin !</h3>
                    <div class="d-flex align-items-center">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0 p-0">
                                <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="col-5 align-self-center">
                    <div id="datetime-box"
                        class="customize-input float-end bg-white border-0 custom-shadow custom-radius p-2 text-center fw-semibold">
                        <!-- JavaScript will insert date & time here -->
                    </div>
                </div>

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
                        const formatted = now.toLocaleString('en-US', options).replace(',', '');
                        document.getElementById('datetime-box').textContent = formatted;
                    }

                    // Update immediately on load
                    updateDateTime();

                    // Update every second
                    setInterval(updateDateTime, 1000);
                </script>

            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- *************************************************************** -->
            <!-- Start First Cards -->
            <!-- *************************************************************** -->
            <div class="row">

                {{-- Total Medicines --}}
                <div class="col-md-3">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="card-body text-center">
                            <i data-feather="package" class="text-primary mb-2"></i>
                            <h5>Total Medicines</h5>
                            <h2 class="fw-bold">{{ $totalMedicines }}</h2>
                        </div>
                    </div>
                </div>

                {{-- Total Stock --}}
                <div class="col-md-3">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="card-body text-center">
                            <i data-feather="database" class="text-success mb-2"></i>
                            <h5>Total Stock</h5>
                            <h2 class="fw-bold">{{ $totalStock }}</h2>
                        </div>
                    </div>
                </div>

                {{-- Low Stock --}}
                <div class="col-md-3">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="card-body text-center">
                            <i data-feather="alert-triangle" class="text-warning mb-2"></i>
                            <h5>Low Stock</h5>
                            <h2 class="fw-bold">{{ $lowStock }}</h2>
                            <small class="text-muted">(1–10 qty)</small>
                        </div>
                    </div>
                </div>

                {{-- Out of Stock --}}
                <div class="col-md-3">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="card-body text-center">
                            <i data-feather="x-circle" class="text-danger mb-2"></i>
                            <h5>Out of Stock</h5>
                            <h2 class="fw-bold">{{ $outOfStock }}</h2>
                        </div>
                    </div>
                </div>
                {{-- Total Inventory Value --}}
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card shadow-sm border-0" style="border-radius:20px;">
                            <div class="card-body text-center">
                                <i data-feather="dollar-sign" class="text-info mb-2"></i>
                                <h5>Total Inventory Value</h5>
                                <h2 class="fw-bold text-success">
                                    ₹ {{ number_format($totalValue, 2) }}
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="card-body">
                            <form method="GET" class="row g-3 align-items-end">

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Filter by Date</label>
                                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Filter by Month</label>
                                    <input type="month" name="month" class="form-control"
                                        value="{{ request('month') }}">
                                </div>

                                <div class="col-md-3 d-flex gap-2">
                                    <button class="btn btn-primary w-100">Filter</button>
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100">Reset</a>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="card shadow-sm border-0" style="border-radius:20px;">
                        <div class="card-body">
                            <h5 class="mb-3 fw-bold">Recent Purchases</h5>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sl. No</th>
                                            <th>Bill No</th>
                                            <th>Customer</th>
                                            <th>Total (₹)</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bills as $bill)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $bill->invoice_no }}</td>
                                                <td>{{ $bill->customer_name }}</td>
                                                <td>₹{{ $bill->total }}</td>
                                                <td>{{ $bill->created_at->format('d M Y') }}</td>
                                                <td><a href="{{ route('admin.billing.show', $bill->id) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="fas fa-eye"></i> View
                                                    </a></td>
                                            </tr>
                                        @endforeach

                                        {{ $bills->links() }}
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end">
                                {{ $bills->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>
@endsection
