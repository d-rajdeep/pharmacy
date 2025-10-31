@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Edit Medicine</h3>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 20px;">
                <form action="{{ route('admin.medicines.update', $medicine->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Medicine Name</label>
                            <input type="text" name="name" value="{{ old('name', $medicine->name) }}"
                                class="form-control" placeholder="Enter medicine name" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $medicine->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Quantity</label>
                            <input type="number" name="quantity" value="{{ old('quantity', $medicine->quantity) }}"
                                class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Price (₹)</label>
                            <input type="number" step="0.01" name="price" value="{{ old('price', $medicine->price) }}"
                                class="form-control" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Expiry Date</label>
                            <input type="date" name="expiry_date"
                                value="{{ old('expiry_date', $medicine->expiry_date) }}" class="form-control">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" rows="3" class="form-control" placeholder="Enter medicine details...">{{ old('description', $medicine->description) }}</textarea>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.medicines.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
