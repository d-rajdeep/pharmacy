@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="container">

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm border-0 p-4" style="border-radius:20px;">
                <h3 class="mb-4 text-dark font-weight-bold">Create New Bill</h3>

                <form method="POST" action="{{ route('admin.billing.store') }}">
                    @csrf

                    {{-- Customer Info --}}
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Customer Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="customer_name"
                                class="form-control bg-light border-0 @error('customer_name') is-invalid @enderror"
                                placeholder="Enter customer name" value="{{ old('customer_name') }}" required
                                maxlength="255">
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-muted">Phone Number <span
                                    class="text-danger">*</span></label>
                            <input type="tel" name="customer_phone"
                                class="form-control bg-light border-0 @error('customer_phone') is-invalid @enderror"
                                placeholder="10-digit mobile number" value="{{ old('customer_phone') }}" required
                                pattern="[0-9]{10}" maxlength="10" title="Please enter exactly 10 digits">
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Medicine Search --}}
                    <div class="mb-4 position-relative">
                        <label class="form-label fw-semibold text-primary">
                            <i class="fas fa-search me-1"></i> Search & Add Medicine
                        </label>
                        <input type="text" id="medicine-search"
                            class="form-control form-control-lg border-primary shadow-sm"
                            placeholder="Start typing medicine name...">
                        <div id="medicine-results" class="list-group position-absolute w-100 shadow-lg mt-1"
                            style="z-index:1000;"></div>
                    </div>

                    {{-- Items Table --}}
                    <div class="table-responsive mb-4">
                        <table class="table table-hover align-middle border">
                            <thead class="table-light">
                                <tr>
                                    <th>Medicine Name</th>
                                    <th width="150">Type</th>
                                    <th width="120">Qty</th>
                                    <th width="150">Unit Price (₹)</th>
                                    <th width="150">Total (₹)</th>
                                    <th width="60" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody id="items-table">
                                <tr id="empty-state">
                                    <td colspan="6" class="text-center text-muted py-4">No medicines added yet. Search
                                        above to begin.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Summary & Submit --}}
                    <div class="row justify-content-end">
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded-3 border">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold text-muted">Subtotal:</span>
                                    <span class="fw-bold" id="subtotal-display">₹0.00</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-3">
                                    <span class="fw-semibold text-muted">Discount (%):</span>
                                    <input type="number" name="discount" id="discount-input"
                                        class="form-control form-control-sm w-50 text-end" placeholder="0" value="0"
                                        min="0" max="100" oninput="calculateGrandTotal()">
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark fs-5">Grand Total:</span>
                                    <span class="fw-bold text-success fs-4" id="grand-total-display">₹0.00</span>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mt-3 py-3 fw-bold shadow-sm"
                                style="border-radius: 10px;">
                                <i class="fas fa-file-invoice me-2"></i> Generate Bill
                            </button>
                        </div>
                    </div>
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
                    if (data.length === 0) {
                        html = `<div class="list-group-item text-muted">No medicines found in stock.</div>`;
                    } else {
                        data.forEach(med => {
                            // Calculate price per tablet for display purposes
                            let pricePerTab = (med.mrp / med.tablets_per_strip).toFixed(2);

                            html += `
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                               onclick="addMedicine(${med.id}, '${med.name.replace(/'/g, "\\'")}', ${med.mrp}, ${med.tablets_per_strip})">
                                <div>
                                    <strong>${med.name}</strong><br>
                                    <small class="text-muted">₹${med.mrp}/Strip | ₹${pricePerTab}/Tab</small>
                                </div>
                                <span class="badge bg-success rounded-pill">${med.quantity} Strips Left</span>
                            </a>`;
                        });
                    }
                    document.getElementById('medicine-results').innerHTML = html;
                });
        });

        // Add Medicine Row
        function addMedicine(id, name, mrp, tabletsPerStrip) {
            // Remove empty state if it exists
            const emptyState = document.getElementById('empty-state');
            if (emptyState) emptyState.remove();

            const tbody = document.getElementById('items-table');

            // Insert Row
            tbody.insertAdjacentHTML('beforeend', `
                <tr class="item-row">
                    <td>
                        <span class="fw-semibold text-dark">${name}</span>
                        <small class="d-block text-muted">(${tabletsPerStrip} tabs/strip)</small>
                        <input type="hidden" name="items[${index}][medicine_id]" value="${id}">
                    </td>
                    <td>
                        <select name="items[${index}][type]" class="form-select row-type" onchange="updateRowTotal(this, ${mrp}, ${tabletsPerStrip})">
                            <option value="strip">Strip</option>
                            <option value="tablet">Tablet</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[${index}][quantity]"
                               class="form-control row-qty"
                               value="1" min="1" step="1"
                               oninput="updateRowTotal(this, ${mrp}, ${tabletsPerStrip})">
                    </td>
                    <td class="row-unit-price fw-medium text-secondary">₹${mrp.toFixed(2)}</td>
                    <td class="row-total fw-bold text-dark" data-val="${mrp}">₹${mrp.toFixed(2)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            index++;
            document.getElementById('medicine-search').value = '';
            document.getElementById('medicine-results').innerHTML = '';

            calculateGrandTotal(); // Update overall totals
        }

        // Update total for a specific row
        function updateRowTotal(element, mrp, tabletsPerStrip) {
            const tr = element.closest('tr');
            const type = tr.querySelector('.row-type').value;
            const qty = parseFloat(tr.querySelector('.row-qty').value) || 1;

            // Calculate actual unit price based on Strip or Tablet
            let unitPrice = (type === 'tablet') ? (mrp / tabletsPerStrip) : mrp;
            let total = qty * unitPrice;

            // Update DOM
            tr.querySelector('.row-unit-price').innerText = '₹' + unitPrice.toFixed(2);
            tr.querySelector('.row-total').innerText = '₹' + total.toFixed(2);
            tr.querySelector('.row-total').setAttribute('data-val', total); // Store raw number for easy sum

            calculateGrandTotal(); // Update overall totals
        }

        // Remove Row
        function removeRow(btn) {
            btn.closest('tr').remove();

            const tbody = document.getElementById('items-table');
            if (tbody.children.length === 0) {
                tbody.innerHTML =
                    `<tr id="empty-state"><td colspan="6" class="text-center text-muted py-4">No medicines added yet. Search above to begin.</td></tr>`;
            }

            calculateGrandTotal();
        }

        // Calculate Subtotal, Discount, and Grand Total
        function calculateGrandTotal() {
            let subtotal = 0;
            document.querySelectorAll('.row-total').forEach(cell => {
                subtotal += parseFloat(cell.getAttribute('data-val')) || 0;
            });

            let discountPercent = parseFloat(document.getElementById('discount-input').value) || 0;
            let discountAmount = (subtotal * discountPercent) / 100;
            let grandTotal = subtotal - discountAmount;

            document.getElementById('subtotal-display').innerText = '₹' + subtotal.toFixed(2);
            document.getElementById('grand-total-display').innerText = '₹' + grandTotal.toFixed(2);
        }
    </script>
@endsection
