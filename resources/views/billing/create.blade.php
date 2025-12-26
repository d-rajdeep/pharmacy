@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="page-wrapper">
                    <div class="container-fluid">
                        <h3 class="mb-3">New Bill</h3>

                        <form method="POST" action="{{ route('admin.billing.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <input name="customer_name" class="form-control" placeholder="Customer Name">
                                </div>
                                <div class="col-md-4">
                                    <input name="customer_phone" class="form-control" placeholder="Phone">
                                </div>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Medicine</th>
                                        <th width="120">Qty</th>
                                        <th width="120">Price</th>
                                        <th width="120">Total</th>
                                        <th width="50"></th>
                                    </tr>
                                </thead>
                                <tbody id="items"></tbody>
                            </table>

                            <button type="button" class="btn btn-secondary mb-3" onclick="addRow()">+ Add Medicine</button>

                            <div class="row">
                                <div class="col-md-3">
                                    <input name="discount" class="form-control" placeholder="Discount">
                                </div>
                                <div class="col-md-3">
                                    <input name="tax" class="form-control" placeholder="Tax">
                                </div>
                            </div>

                            <button class="btn btn-success mt-3">Generate Bill</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let medicines = @json($medicines);
        let rowIdx = 0; // Add a counter

        function addRow() {
            let row = `
    <tr>
        <td>
            <select name="items[${rowIdx}][medicine_id]" class="form-select">
                <option value="">Select Medicine</option>
                ${medicines.map(m => `<option value="${m.id}" data-price="${m.price}">${m.name}</option>`).join('')}
            </select>
        </td>
        <td><input name="items[${rowIdx}][quantity]" type="number" class="form-control qty" value="1" min="1"></td>
        <td class="price">0.00</td>
        <td class="total">0.00</td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">×</button></td>
    </tr>`;

            document.getElementById('items').insertAdjacentHTML('beforeend', row);
            rowIdx++; // Increment for the next row
        }
    </script>
@endsection
