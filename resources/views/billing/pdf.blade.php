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
    </style>
</head>

<body>
    <div class="header">
        <h1>PHARMACY INVOICE</h1>
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
                <th>Qty</th>
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
                <td>Tax:</td>
                <td>+{{ number_format($bill->tax, 2) }}</td>
            </tr>
            <tr>
                <td>Discount:</td>
                <td>-{{ number_format($bill->discount, 2) }}</td>
            </tr>
            <tr style="font-weight: bold;">
                <td>Total:</td>
                <td>{{ number_format($bill->total, 2) }}</td>
            </tr>
        </table>
    </div>
</body>

</html>
