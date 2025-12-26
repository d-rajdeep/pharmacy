@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="card shadow-sm border-0 p-4" style="border-radius:20px; max-width:700px;">
                <h4 class="mb-3">Adjust Stock</h4>

                <form method="POST" action="{{ route('admin.medicines.adjust', $medicine->id) }}">
                    @csrf

                    <div class="mb-3">
                        <label>Medicine</label>
                        <input class="form-control" value="{{ $medicine->name }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Current Stock</label>
                        <input class="form-control" value="{{ $medicine->quantity }}" disabled>
                    </div>

                    <div class="mb-3">
                        <label>Adjustment Type</label>
                        <select name="type" class="form-select" required>
                            <option value="">Select</option>
                            <option value="in">Stock In</option>
                            <option value="out">Stock Out</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Quantity</label>
                        <input type="number" name="quantity" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Reason</label>
                        <input type="text" name="reason" class="form-control">
                    </div>

                    <button class="btn btn-success">Update Stock</button>
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
