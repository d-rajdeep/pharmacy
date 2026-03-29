<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-box {
            border: 1px solid #eee;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f4f4f4;
            text-align: left;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }

        .total-section {
            float: right;
            width: 200px;
            margin-top: 20px;
        }

        /* Added professional footer styling */
        .footer-note {
            clear: both;
            /* Prevents overlapping with the floated total-section */
            text-align: center;
            margin-top: 60px;
            font-size: 11px;
            color: #666;
            font-style: italic;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>MEDHI MEDICOS</h1>
        <p>Invoice #{{ $bill->invoice_no }} | Date: {{ $bill->created_at->format('d-m-Y') }}</p>
    </div>

    <div style="margin-bottom: 20px;">
        <strong>Customer Details:</strong><br>
        Name: {{ $bill->customer_name }}<br>
        Phone: {{ $bill->customer_phone }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Medicine</th>
                <th>Qty (Strip/Tablet)</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bill->items as $item)
                <tr>
                    <td>{{ $item->medicine->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td>{{ number_format($bill->subtotal, 2) }}</td>
            </tr>
            <tr>
                <td>Discount (%):</td>
                <td>{{ number_format($bill->discount, 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Total:</td>
                <td>{{ number_format($bill->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer-note">
        This is a computer-generated invoice and does not require a physical signature.
    </div>
</body>

</html>
