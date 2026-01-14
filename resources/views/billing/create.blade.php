@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container">
            <div class="card shadow-sm p-4" style="border-radius:20px;">
                <h3 class="mb-4">New Bill</h3>

                <form method="POST" action="{{ route('admin.billing.store') }}">
                    @csrf

                    {{-- Customer Info --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input name="customer_name" class="form-control" placeholder="Customer Name">
                        </div>
                        <div class="col-md-4">
                            <input name="customer_phone" class="form-control" placeholder="Phone Number">
                        </div>
                    </div>

                    {{-- Medicine Search --}}
                    <div class="mb-3 position-relative">
                        <label class="form-label fw-semibold">Search Medicine</label>
                        <input type="text" id="medicine-search" class="form-control" placeholder="Type medicine name...">

                        <div id="medicine-results" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                    </div>

                    {{-- Items Table --}}
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Medicine</th>
                                <th width="120">Qty</th>
                                <th width="120">Price</th>
                                <th width="120">Total</th>
                                <th width="50"></th>
                            </tr>
                        </thead>
                        <tbody id="items-table"></tbody>
                    </table>

                    {{-- Discount --}}
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <input name="discount" class="form-control" placeholder="Discount (%)">
                        </div>
                    </div>

                    <button class="btn btn-success mt-4">
                        <i class="fas fa-file-invoice"></i> Generate Bill
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT --}}
    <script>
        let index = 0;

        // Search Medicine
        document.getElementById('medicine-search').addEventListener('keyup', function() {
            let query = this.value;

            if (query.length < 2) {
                document.getElementById('medicine-results').innerHTML = '';
                return;
            }

            fetch(`{{ route('admin.billing.search.medicine') }}?q=${query}`)
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    data.forEach(med => {
                        html += `
                    <a href="#" class="list-group-item list-group-item-action"
                       onclick="addMedicine(${med.id}, '${med.name}', ${med.price})">
                        ${med.name} <small class="text-muted">(Stock: ${med.quantity})</small>
                    </a>`;
                    });
                    document.getElementById('medicine-results').innerHTML = html;
                });
        });

        // Add Medicine Row
        function addMedicine(id, name, price) {
            const tbody = document.getElementById('items-table');

            tbody.insertAdjacentHTML('beforeend', `
        <tr>
            <td>
                ${name}
                <input type="hidden" name="items[${index}][medicine_id]" value="${id}">
            </td>
            <td>
                <input type="number" name="items[${index}][quantity]"
                       class="form-control qty"
                       value="1" min="1"
                       oninput="updateRowTotal(this, ${price})">
            </td>
            <td>₹${price.toFixed(2)}</td>
            <td class="row-total">₹${price.toFixed(2)}</td>
            <td>
                <button type="button"
                        class="btn btn-sm btn-danger"
                        onclick="this.closest('tr').remove()">×</button>
            </td>
        </tr>
    `);

            index++;
            document.getElementById('medicine-search').value = '';
            document.getElementById('medicine-results').innerHTML = '';
        }

        // Update total when qty changes
        function updateRowTotal(input, price) {
            let qty = parseInt(input.value) || 1;
            let total = qty * price;
            input.closest('tr').querySelector('.row-total').innerText = '₹' + total.toFixed(2);
        }
    </script>
@endsection
