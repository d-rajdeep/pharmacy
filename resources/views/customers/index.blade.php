@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Customers List</h3>
                </div><br></br>

                <div class="card-body p-0">

                    <table class="table table-bordered table-striped mb-0">

                        <thead class="table-light">
                            <tr>
                                <th width="60">SL</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Last Purchase</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($customers as $customer)
                                <tr>
                                    <td>{{ $loop->iteration + ($customers->currentPage() - 1) * $customers->perPage() }}
                                    </td>

                                    <td>{{ $customer->customer_name }}</td>

                                    <td>{{ $customer->customer_phone }}</td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($customer->last_purchase)->format('d M Y h:i A') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        No customers found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>

                </div>

                <div class="card-footer">
                    {{ $customers->links() }}
                </div>

            </div>

        </div>
    </div>
@endsection
