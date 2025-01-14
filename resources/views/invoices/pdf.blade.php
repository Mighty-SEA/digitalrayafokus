<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        :root {
            --primary-color: #0f2147;
            --primary-light: #dbeafe;
            --secondary-color: #475569;
            --accent-color: #f8fafc;
        }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            line-height: 1.3;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background: #fff;
        }
        .container {
            padding: 15px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding: 15px;
            background: var(--primary-light);
            border-radius: 8px;
        }
        .logo {
            max-width: 100px;
            max-height: 40px;
        }
        .company-info {
            text-align: right;
            font-size: 9px;
            color: var(--secondary-color);
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            background: var(--accent-color);
            padding: 10px;
            border-radius: 6px;
        }
        .invoice-left {
            width: 300px;
            text-align: left;
        }
        .invoice-right {
            width: 300px;
            text-align: right;
        }
        .invoice-details {
            font-size: 10px;
            width: 300px;
            text-align: right;
            margin-left: auto;
            padding-right: 20px;
        }
        .customer-details {
            font-size: 10px;
            width: 300px;
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-paid { background: #dcfce7; color: #166534; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 10px;
            background: white;
            border-radius: 6px;
            overflow: hidden;
        }
        thead {
            background: var(--primary-color);
        }
        th {
            color: white;
            padding: 8px 6px;
            text-align: left;
            font-weight: 600;
            font-size: 9px;
            border-bottom: 2px solid var(--primary-light);
        }
        th:first-child {
            border-top-left-radius: 6px;
        }
        th:last-child {
            border-top-right-radius: 6px;
        }
        .items-table th {
            background: linear-gradient(180deg, var(--primary-color) 0%, #1eaf70 100%);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .items-table td {
            padding: 6px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .items-table tr:last-child td {
            border-bottom: none;
        }
        .items-table tr:nth-child(even) {
            background-color: var(--accent-color);
        }
        td {
            padding: 4px 6px;
            border-bottom: 1px solid #e2e8f0;
        }
        .total-section {
            width: 300px;
            margin: 20px 0 20px auto;
            padding: 15px;
            background: #f8fafc;
            border-radius: 6px;
        }
        .total-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .total-section td {
            padding: 4px 0;
        }
        .subtotal-row td {
            padding: 6px;
            color: #475569;
        }
        .total-row td {
            font-weight: bold;
            color: #0f2147;
        }
        .exchange-row td {
            padding-top: 4px;
            font-size: 9px;
            color: #64748b;
        }
        .footer {
            clear: both;
            margin-top: 15px;
            padding: 8px;
            border-top: 1px solid var(--primary-light);
            text-align: center;
            font-size: 8px;
            color: var(--secondary-color);
            background: var(--accent-color);
            border-radius: 6px;
        }
        .currency-note {
            font-size: 8px;
            color: var(--secondary-color);
            margin-top: 5px;
            font-style: italic;
            text-align: right;
        }
        .section-title {
            color: var(--primary-color);
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .company-name {
            color: var(--primary-color);
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
            letter-spacing: 0.5px;
        }
        .invoice-number {
            color: var(--primary-color);
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-align: right;
        }
        p {
            margin: 2px 0;
        }
        .table-header {
            background: var(--primary-color);
            color: white;
            padding: 8px;
            margin: 10px 0;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .table-header-left {
            display: flex;
            gap: 20px;
        }
        .table-header-right {
            text-align: right;
        }
        .table-header-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        .table-header-label {
            font-size: 8px;
            opacity: 0.9;
            text-transform: uppercase;
        }
        .table-header-value {
            font-size: 10px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .items-table th {
            background: var(--primary-color);
            color: white;
            padding: 8px 6px;
            text-align: left;
            border: 1px solid #1e293b;
        }
        .items-table td {
            padding: 8px 6px;
            border: 1px solid #e2e8f0;
        }
        .items-table tr:nth-child(even) {
            background-color: var(--accent-color);
        }
        .items-table {
            border-radius: 6px;
            overflow: hidden;
        }
        .items-table th:first-child {
            border-top-left-radius: 6px;
        }
        .items-table th:last-child {
            border-top-right-radius: 6px;
        }
        .invoice-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px 0;
        }
        .bill-section {
            width: 40%;
            text-align: left;
        }
        .invoice-details-section {
            width: 40%;
            text-align: right;
        }
        .invoice-title {
            font-size: 14px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            margin-left: 8px;
        }
        .invoice-header-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin: 20px 0;
        }
        .bill-section {
            text-align: left;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-title {
            font-size: 14px;
            font-weight: bold;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-bottom: 5px;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            margin-left: 8px;
        }
        .bill-section {
            text-align: left;
            margin: 20px 0;
        }
        .invoice-header {
            text-align: right;
            margin: 20px 0;
        }
        .invoice-title {
            font-size: 14px;
            font-weight: bold;
            color: var(--primary-color);
            display: inline-flex;
            align-items: center;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            margin-left: 8px;
            background-color: #fff3cd;
            color: #856404;
        }
        .header-table {
            width: 100%;
            margin: 20px 0;
            border: none;
        }
        .header-table td {
            vertical-align: top;
            border: none;
            padding: 0;
        }
        .header-table .left-col {
            text-align: left;
            width: 50%;
        }
        .header-table .right-col {
            text-align: right;
            width: 50%;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            margin-left: 8px;
            background-color: #fff3cd;
            color: #856404;
        }
        .payment-info {
            margin: 15px 0;
            padding: 8px;
            background: #f8fafc;
            border-radius: 6px;
            text-align: center;
            font-size: 10px;
        }
        .payment-table {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
        }
        .payment-table td {
            padding: 4px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                @if($settings['logo'])
                    <img src="{{ storage_path('app/public/' . $settings['logo']) }}" class="logo" alt="Company Logo">
                @endif
                <h2 class="company-name">{{ $settings['name'] }}</h2>
            </div>
            <div class="company-info">
                <p>{{ $settings['address'] }}</p>
                <p>Email: {{ $settings['email'] }}</p>
                <p>Phone: {{ $settings['phone'] }}</p>
            </div>
        </div>

        <table class="header-table">
            <tr>
                <td class="left-col">
                    <div class="section-title">Bill To:</div>
                    <p>{{ $invoice->customer->nama }}</p>
                    <p>Email: {{ $invoice->customer->email }}</p>
                    <p>Phone: {{ $invoice->customer->phone }}</p>
                </td>
                <td class="right-col">
                    <div class="invoice-title">
                        INVOICE #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                        <span class="status-badge">{{ ucfirst($invoice->status) }}</span>
                    </div>
                    <p>Invoice Date: {{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</p>
                    <p>Due Date: {{ date('d/m/Y', strtotime($invoice->due_date)) }}</p>
                </td>
            </tr>
        </table>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 30%;">ITEM</th>
                    <th style="width: 25%;">DESCRIPTION</th>
                    <th style="text-align: center; width: 10%;">QTY</th>
                    <th style="text-align: right; width: 17%;">PRICE</th>
                    <th style="text-align: right; width: 18%;">TOTAL</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->item as $item)
                    <tr>
                        <td style="font-weight: 600;">{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        @if($item->is_dollar)
                            <td style="text-align: right;">${{ number_format($item->price_dollar, 2) }}</td>
                            <td style="text-align: right;">${{ number_format($item->amount_dollar, 2) }}</td>
                        @else
                            <td style="text-align: right;">Rp {{ number_format($item->price_rupiah, 0, ',', '.') }}</td>
                            <td style="text-align: right;">Rp {{ number_format($item->amount_rupiah, 0, ',', '.') }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="total-section">
            <table>
                <tr>
                    <td>Subtotal IDR:</td>
                    <td style="text-align: right;">
                        Rp {{ number_format($invoice->item->where('is_dollar', false)->sum('amount_rupiah'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td>Subtotal USD:</td>
                    <td style="text-align: right;">
                        ${{ number_format($invoice->item->where('is_dollar', true)->sum('amount_dollar'), 2) }}
                    </td>
                </tr>
                <tr style="border-top: 1px solid #e2e8f0; font-weight: bold;">
                    <td style="padding-top: 8px;">Total Amount:</td>
                    <td style="text-align: right; padding-top: 8px;">
                        Rp {{ number_format(
                            $invoice->item->where('is_dollar', false)->sum('amount_rupiah') + 
                            ($invoice->item->where('is_dollar', true)->sum('amount_dollar') * $invoice->current_dollar), 
                            0, ',', '.'
                        ) }}
                    </td>
                </tr>
                <tr style="font-size: 9px; color: #666;">
                    <td>Exchange Rate:</td>
                    <td style="text-align: right;">1 USD = Rp {{ number_format($invoice->current_dollar, 0, ',', '.') }}</td>
                </tr>
            </table>
            <div style="font-size: 9px; color: #666; margin-top: 4px;">* Exchange rate at invoice creation</div>
        </div>

        <div class="payment-info">
            <strong>INFORMASI PEMBAYARAN:</strong>&nbsp;&nbsp;BRI&nbsp;&nbsp;|&nbsp;&nbsp;398329283298&nbsp;&nbsp;|&nbsp;&nbsp;a.n Wahyu
        </div>

        <div class="footer">
            <p style="font-weight: 600; color: var(--primary-color);">Thank you for your business!</p>
            <p>This is a computer-generated document. No signature is required.</p>
            <p style="font-size: 8px;">Generated on {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>

