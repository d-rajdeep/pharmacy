@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Add Medicine Category</h3>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">
            <div class="card shadow-sm border-0 p-4" style="border-radius: 20px;">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Category Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="form-control form-control-lg" placeholder="Enter category name" required>
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="3" class="form-control form-control-lg" placeholder="Enter short description">{{ old('description') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-success me-2 shadow-sm">
                            <i class="fas fa-save"></i> Save
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary shadow-sm">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.footer')
    </div>
@endsection
