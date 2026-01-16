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

        <div class="container">

            <h4 class="mb-4">Sales Overview</h4>

            <div class="row">
                <div class="col-md-4">
                    <canvas id="dailyChart"></canvas>
                </div>

                <div class="col-md-4">
                    <canvas id="weeklyChart"></canvas>
                </div>

                <div class="col-md-4">
                    <canvas id="monthlyChart"></canvas>
                </div>
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
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        /* ================= DAILY ================= */
        new Chart(document.getElementById('dailyChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($dailySales->pluck('date')) !!},
                datasets: [{
                    label: 'Daily Sales (₹)',
                    data: {!! json_encode($dailySales->pluck('total')) !!}
                }]
            }
        });

        /* ================= WEEKLY ================= */
        new Chart(document.getElementById('weeklyChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($weeklySales->pluck('date')) !!},
                datasets: [{
                    label: 'Weekly Sales (₹)',
                    data: {!! json_encode($weeklySales->pluck('total')) !!}
                }]
            }
        });

        /* ================= MONTHLY ================= */
        new Chart(document.getElementById('monthlyChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlySales->pluck('month')->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)))) !!},
                datasets: [{
                    label: 'Monthly Sales (₹)',
                    data: {!! json_encode($monthlySales->pluck('total')) !!}
                }]
            }
        });
    </script>
@endsection
