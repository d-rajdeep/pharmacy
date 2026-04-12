@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="page-breadcrumb">
            <div class="row align-items-center">
                <div class="col-6">
                    <h3 class="page-title text-dark font-weight-medium mb-0">Create New Bill</h3>
                </div>
                <div class="col-6 text-end">
                    <a href="{{ route('admin.billing.index') }}" class="btn btn-secondary shadow-sm">
                        <i class="fas fa-arrow-left"></i> Back to Bills
                    </a>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3">

            @if (session('error'))
                <div class="alert alert-danger shadow-sm rounded-3">{{ session('error') }}</div>
            @endif

            <div class="card shadow-sm border-0 p-4" style="border-radius: 20px;">
                <form method="POST" action="{{ route('admin.billing.store') }}">
                    @csrf

                    {{-- Customer Info Section --}}
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label fw-semibold">Customer Name <span class="text-danger">*</span></label>
                            <input type="text" name="customer_name"
                                class="form-control form-control-lg @error('customer_name') is-invalid @enderror"
                                placeholder="Enter customer name" value="{{ old('customer_name') }}" required
                                maxlength="255">
                            @error('customer_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="tel" name="customer_phone"
                                class="form-control form-control-lg @error('customer_phone') is-invalid @enderror"
                                placeholder="10-digit mobile number" value="{{ old('customer_phone') }}" required
                                pattern="[0-9]{10}" maxlength="10" title="Please enter exactly 10 digits">
                            @error('customer_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Medicine Search --}}
                    <div class="mb-4 position-relative" style="z-index: 1050;">
                        <label class="form-label fw-semibold text-primary">
                            <i class="fas fa-search me-1"></i> Search & Add Medicine
                        </label>
                        <input type="text" id="medicine-search"
                            class="form-control form-control-lg border-primary shadow-sm"
                            placeholder="Start typing medicine name...">

                        <div id="medicine-results"
                            class="list-group position-absolute w-100 shadow-lg mt-1 bg-white border-0"
                            style="z-index: 1050; max-height: 300px; overflow-y: auto; border-radius: 10px;">
                        </div>
                    </div>

                    {{-- Items Table --}}
                    <div class="border rounded-3 overflow-hidden mb-4">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">Medicine Name</th>
                                        <th width="150">Type</th>
                                        <th width="120">Qty</th>
                                        <th width="150">Unit Price (₹)</th>
                                        <th width="150">Total (₹)</th>
                                        <th width="80" class="text-center pe-3">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="items-table" class="border-top-0">
                                    <tr id="empty-state">
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <i class="fas fa-pills fs-3 mb-2 opacity-50 d-block"></i>
                                            No medicines added yet. Search above to begin.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Summary & Submit Area --}}
                    <div class="row justify-content-end">
                        <div class="col-lg-5 col-md-6">

                            {{-- Payment Status Box --}}
                            <div class="mb-3 p-3 border rounded-3 bg-white shadow-sm">
                                <label class="form-label fw-semibold text-dark d-block mb-3">Payment Status <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex gap-4">
                                    <div class="form-check custom-radio d-flex align-items-center">
                                        <input class="form-check-input border-secondary shadow-none me-2" type="radio"
                                            name="payment_status" id="statusPaid" value="paid" checked
                                            style="width: 1.3rem; height: 1.3rem; cursor: pointer;">
                                        <label class="form-check-label text-success fw-bold fs-6" for="statusPaid"
                                            style="cursor: pointer; padding-top: 2px;">
                                            <i class="fas fa-check-circle me-1"></i> Paid Now
                                        </label>
                                    </div>
                                    <div class="form-check custom-radio d-flex align-items-center">
                                        <input class="form-check-input border-secondary shadow-none me-2" type="radio"
                                            name="payment_status" id="statusPending" value="pending"
                                            style="width: 1.3rem; height: 1.3rem; cursor: pointer;">
                                        <label class="form-check-label text-danger fw-bold fs-6" for="statusPending"
                                            style="cursor: pointer; padding-top: 2px;">
                                            <i class="fas fa-clock me-1"></i> Credit (Pending)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            {{-- Totals Box --}}
                            <div class="bg-light p-4 rounded-3 border border-light-subtle shadow-sm mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-semibold text-muted">Subtotal:</span>
                                    <span class="fw-bold text-dark" id="subtotal-display">₹0.00</span>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                                    <span class="fw-semibold text-muted">Discount (%):</span>
                                    <input type="number" name="discount" id="discount-input"
                                        class="form-control form-control-sm w-25 text-end fw-bold" placeholder="0"
                                        value="0" min="0" max="100" oninput="calculateGrandTotal()">
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold text-dark fs-5">Grand Total:</span>
                                    <span class="fw-bold text-success fs-3" id="grand-total-display">₹0.00</span>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.billing.index') }}"
                                    class="btn btn-secondary shadow-sm py-2 flex-grow-1">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="btn btn-success shadow-sm py-2 flex-grow-1 fw-bold text-white">
                                    <i class="fas fa-file-invoice me-1"></i> Generate Bill
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @include('layouts.footer')
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
                        html =
                            `<div class="list-group-item text-muted border-0 p-3">No medicines found in stock.</div>`;
                    } else {
                        data.forEach(med => {
                            let pricePerTab = (med.mrp / med.tablets_per_strip).toFixed(2);

                            html += `
                            <a href="javascript:void(0)" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center border-bottom"
                               onclick="addMedicine(${med.id}, '${med.name.replace(/'/g, "\\'")}', ${med.mrp}, ${med.tablets_per_strip}, '${med.description}')">
                                <div>
                                    <strong class="text-dark">${med.name}</strong><br>
                                    <small class="text-muted">₹${med.mrp}/Qnty | ₹${pricePerTab}/Tab | Rack No: ${med.description ?? 'N/A'}</small>
                                </div>
                                <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">${med.quantity} Strips</span>
                            </a>`;
                        });
                    }
                    document.getElementById('medicine-results').innerHTML = html;
                });
        });

        // Add Medicine Row
        function addMedicine(id, name, mrp, tabletsPerStrip, description) {
            const emptyState = document.getElementById('empty-state');
            if (emptyState) emptyState.remove();

            const tbody = document.getElementById('items-table');

            tbody.insertAdjacentHTML('beforeend', `
                <tr class="item-row">
                    <td class="ps-3">
                        <span class="fw-bold text-dark d-block">${name}</span>
                        <small class="text-muted">(${tabletsPerStrip} tabs/strip)</small>
                        <input type="hidden" name="items[${index}][medicine_id]" value="${id}">
                    </td>
                    <td>
                        <select name="items[${index}][type]" class="form-select form-select-sm row-type shadow-none" onchange="updateRowTotal(this, ${mrp}, ${tabletsPerStrip})">
                            <option value="strip">Strip</option>
                            <option value="tablet">Tablet</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" name="items[${index}][quantity]"
                               class="form-control form-control-sm row-qty text-center shadow-none"
                               value="1" min="1" step="1"
                               oninput="updateRowTotal(this, ${mrp}, ${tabletsPerStrip})">
                    </td>
                    <td class="row-unit-price fw-medium text-secondary">₹${mrp.toFixed(2)}</td>
                    <td class="row-total fw-bold text-dark" data-val="${mrp}">₹${mrp.toFixed(2)}</td>
                    <td class="text-center pe-3">
                        <button type="button" class="btn btn-sm btn-light text-danger shadow-sm border" onclick="removeRow(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);

            index++;
            document.getElementById('medicine-search').value = '';
            document.getElementById('medicine-results').innerHTML = '';

            calculateGrandTotal();
        }

        // Update total for a specific row
        function updateRowTotal(element, mrp, tabletsPerStrip) {
            const tr = element.closest('tr');
            const type = tr.querySelector('.row-type').value;
            const qty = parseFloat(tr.querySelector('.row-qty').value) || 1;

            let unitPrice = (type === 'tablet') ? (mrp / tabletsPerStrip) : mrp;
            let total = qty * unitPrice;

            tr.querySelector('.row-unit-price').innerText = '₹' + unitPrice.toFixed(2);
            tr.querySelector('.row-total').innerText = '₹' + total.toFixed(2);
            tr.querySelector('.row-total').setAttribute('data-val', total);

            calculateGrandTotal();
        }

        // Remove Row
        function removeRow(btn) {
            btn.closest('tr').remove();

            const tbody = document.getElementById('items-table');
            if (tbody.children.length === 0) {
                tbody.innerHTML =
                    `<tr id="empty-state"><td colspan="6" class="text-center text-muted py-5"><i class="fas fa-pills fs-3 mb-2 opacity-50 d-block"></i>No medicines added yet. Search above to begin.</td></tr>`;
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
