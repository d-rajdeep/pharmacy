@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-medium mb-0">All Medicines</h3>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.medicines.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add Medicine
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h4 class="card-title mb-3">Medicine List</h4>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Sl. No</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Quantity</th>
                                    <th>Price (₹)</th>
                                    <th>Expiry Date</th>
                                    <th>Description</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($medicines as $medicine)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->category->name ?? 'N/A' }}</td>
                                        <td>{{ $medicine->quantity }}</td>
                                        <td>₹{{ number_format($medicine->price, 2) }}</td>
                                        <td>{{ $medicine->expiry_date ?? '-' }}</td>
                                        <td>{{ Str::limit($medicine->description, 50) }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.medicines.edit', $medicine->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.medicines.destroy', $medicine->id) }}"
                                                method="POST" class="d-inline-block"
                                                onsubmit="return confirm('Are you sure you want to delete this medicine?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">No medicines found.</td>
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
