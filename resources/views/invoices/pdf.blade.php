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
            margin-bottom: 15px;
            padding: 10px;
            background: var(--primary-light);
            border-radius: 6px;
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
        .invoice-details, .customer-details {
            font-size: 10px;
            width: 48%;
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
            width: 200px;
            float: right;
            margin-top: 8px;
            background: var(--primary-light);
            padding: 8px;
            border-radius: 6px;
        }
        .total-section table {
            font-size: 9px;
            margin: 0;
        }
        .total-section td {
            border: none;
            padding: 3px 6px;
        }
        .total-row {
            font-weight: bold;
            color: var(--primary-color);
            background: white !important;
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
        }
        .section-title {
            color: var(--primary-color);
            font-size: 11px;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .company-name {
            color: var(--primary-color);
            font-size: 14px;
            font-weight: bold;
            margin: 3px 0;
        }
        .invoice-number {
            color: var(--primary-color);
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 5px 0;
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

        <div class="invoice-header">
            <div class="invoice-details">
                <h1 class="invoice-number">
                    INVOICE #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}
                    <span class="status-badge status-{{ $invoice->status }}">{{ ucfirst($invoice->status) }}</span>
                </h1>
                <p><strong>Invoice Date:</strong> {{ date('d/m/Y', strtotime($invoice->invoice_date)) }}</p>
                <p><strong>Due Date:</strong> {{ date('d/m/Y', strtotime($invoice->due_date)) }}</p>
            </div>
            <div class="customer-details">
                <div class="section-title">Bill To:</div>
                <p style="font-weight: 600;">{{ $invoice->customer->nama }}</p>
                <p>Email: {{ $invoice->customer->email }}</p>
                <p>Phone: {{ $invoice->customer->phone }}</p>
            </div>
        </div>
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 35%;">ITEM</th>
                    <th style="width: 25%;">DESCRIPTION</th>
                    <th style="text-align: center; width: 10%;">QTY</th>
                    @if($invoice->is_dollar)
                        <th style="text-align: right; width: 15%;">PRICE (USD)</th>
                        <th style="text-align: right; width: 15%;">TOTAL (USD)</th>
                    @else
                        <th style="text-align: right; width: 15%;">PRICE (IDR)</th>
                        <th style="text-align: right; width: 15%;">TOTAL (IDR)</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->item as $item)
                    <tr>
                        <td style="font-weight: 600;">{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td style="text-align: center;">{{ $item->quantity }}</td>
                        @if($invoice->is_dollar)
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
                    <td><strong>Subtotal:</strong></td>
                    <td style="text-align: right;">
                        @if($invoice->is_dollar)
                            ${{ number_format($invoice->item->sum('amount_dollar'), 2) }}
                        @else
                            Rp {{ number_format($invoice->item->sum('amount_rupiah'), 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @if($invoice->is_dollar)
                    <tr>
                        <td><strong>IDR Equivalent:</strong></td>
                        <td style="text-align: right;">Rp {{ number_format($invoice->item->sum('amount_dollar') * $invoice->current_dollar, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>Exchange Rate:</strong></td>
                        <td style="text-align: right;">1 USD = Rp {{ number_format($invoice->current_dollar, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </table>
            @if($invoice->is_dollar)
                <div class="currency-note">* Exchange rate at invoice creation</div>
            @endif
        </div>

        <div class="footer">
            <p style="font-weight: 600; color: var(--primary-color);">Thank you for your business!</p>
            <p>This is a computer-generated document. No signature is required.</p>
            <p style="font-size: 8px;">Generated on {{ date('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>

