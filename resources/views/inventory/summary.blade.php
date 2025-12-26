@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <h3 class="mb-4">Inventory Summary</h3>

            <div class="row g-4">
                @foreach ([
            'Total Medicines' => $totalMedicines,
            'Total Stock Qty' => $totalStock,
            'Low Stock' => $lowStock,
            'Out of Stock' => $outOfStock,
            'Inventory Value (₹)' => number_format($totalValue, 2),
        ] as $label => $value)
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 text-center p-4" style="border-radius:20px;">
                            <h6 class="text-muted">{{ $label }}</h6>
                            <h2 class="fw-bold">{{ $value }}</h2>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
