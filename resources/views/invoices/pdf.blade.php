<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
        }

        .invoice-details {
            text-align: right;
        }

        .invoice-number {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .invoice-date {
            font-size: 16px;
            color: #555;
        }

        .invoice-to {
            margin-bottom: 20px;
        }

        .invoice-from {
            margin-bottom: 20px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd; }

        th {
            background-color: #007bff;
            color: white;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="name">{{ $company->name }}</div>
            <div class="invoice-details">
                <div class="invoice-number">Invoice #{{ $invoice->id }}</div>
                <div class="invoice-date">Date: {{ $invoice->invoice_date}}</div>
            </div>
        </div>
        <div class="invoice-to">
            <div class="title">Bill To:</div>
            <div>{{ $invoice->customer->nama }}</div>
        </div>
        <div class="invoice-from">
            <div class="title">From:</div>
            <div>My Company</div>
            <div>456 Another St</div>
            <div>City, State, ZIP</div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
              @foreach($invoice->item as $item)
              <tr>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->quantity }}</td>
                  <td>RP {{ number_format($item->price_rupiah, 0, ',', '.') }}</td>
                  <td>RP {{ number_format($item->quantity * $item->price_rupiah, 0, ',', '.') }}</td>
              </tr>
          @endforeach
            </tbody>
        </table>
        <div class="total">Total: $35.00</div>
        <div class="footer">Thank you for your business!</div>
    </div>
</body>
</html>