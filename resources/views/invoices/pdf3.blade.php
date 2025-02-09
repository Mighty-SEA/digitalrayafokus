<!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</title>
        <style>
            /* Tambahan untuk dompdf */
            * {
                font-family: 'Roboto', sans-serif;  /* Gunakan font yang lebih modern */
            }
            
            /* Tetapkan ukuran halaman A4 */
            @page {
                size: A4;
                margin: 0;
            }
            
            /* Tambahkan !important untuk memastikan style diterapkan */
            .page {
                width: 100%;
                padding: 40px;
                margin: auto;
                box-sizing: border-box;
                background-color: #f7f9fc; /* Warna latar belakang lembut */
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
                border-radius: 8px; /* Tambahkan border-radius */
            }
            
            /* Pastikan gambar tidak melebihi container */
            img {
                max-width: 100%;
                height: auto !important;
            }
            
            /* Tambahan untuk tabel */
            table, tr, td, th, tbody, thead, tfoot {
                page-break-inside: avoid !important;
                /* Hapus border pada tabel */
                border: none;
            }
            
            * {
                box-sizing: border-box;
            }
            body, html {
                font-size: 10pt;
                font-family: 'Roboto', Arial, sans-serif;
                margin: 0;
                padding: 0;
                line-height: 1.5;
                color: #2d3436;
                background: #fff;
            }
            .page {
                position: relative;
                background: #ffffff;
                width: 100%;
                padding: 40px;
                border: 1px solid #dfe6e9;
            }
            .header {
                overflow: auto;
                margin-bottom: 40px;
                background-color: #e3e8ee; /* Warna latar belakang header */
                padding: 15px;
                border-radius: 8px; /* Tambahkan border-radius */
            }
            .logo-section {
                display: inline-block;
                width: 45%;
                vertical-align: top;
            }
            .invoice-section {
                display: inline-block;
                width: 45%;
                text-align: right;
                vertical-align: top;
            }
            .logo-container {
                margin-bottom: 4px;
                margin-left: 10px;
            }
            .logo-image {
                width: 120px;
                height: auto;
            }
            .company-name {
                font-size: 11px;
                color: #636e72;
                margin-top: 4px;
            }
            .invoice-title {
                font-size: 32px;
                font-weight: bold;
                margin-bottom: 10px;
                color: #34495e; /* Warna teks judul */
            }
            .invoice-info {
                font-size: 12px;
                line-height: 1.4;
                color: #636e72;
            }
            table {
                width: 90.4%;
                border-collapse: collapse;
                overflow: hidden;
                margin-top: 20px;
            }
            th, td {
                padding: 10px 8px;
                border-bottom: 1px solid #e0e6ed;
                text-align: left;
            }
            th {
                background-color: #f1f3f5;
                padding: 12px 8px;
                border-bottom: 2px solid #e0e6ed;
                font-weight: bold;
                color: #34495e; /* Warna teks header tabel */
            }
            td {
                padding: 10px 8px;
                border-bottom: 1px solid #e0e6ed;
            }
            tbody tr:last-child td {
                border-bottom: none;
            }
            .info-totals-container {
                overflow: auto;
                margin: 20px 0;
            }
            .billing-info {
                display: inline-block;
                width: 45%;
                vertical-align: top;
                margin-top: -15px;
            }
            .billing-info h3 {
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 15px;
                color: #2d3436;
            }
            .billing-info p {
                margin: 5px 0;
                font-size: 12px;
                color: #636e72;
            }
            .totals {
                display: inline-block;
                width: 45%;
                vertical-align: top;
            }
            .totals table {
                margin: 0;
                width: 100%;
            }
            .totals td {
                padding: 5px 0;
            }
            .totals td:last-child {
                text-align: right;
            }
            .message {
                margin-top: 60px;
                padding: 20px;
                background: #f1f3f5;
                border-radius: 8px; /* Tambahkan border-radius */
            }
            .message h3 {
                font-size: 14px;
                font-weight: bold;
                margin-bottom: 15px;
                color: #2d3436;
            }
            .message p {
                font-size: 12px;
                color: #636e72;
            }
            .message .underline {
                border-bottom: 1px solid #2d3436;
                padding-bottom: 10px;
                margin-top: 20px;
                width: 250px;
            }
            .generated-info {
                margin-top: 40px;
                font-size: 11px;
                color: #636e72;
                line-height: 1.4;
            }
            th:nth-child(1), td:nth-child(1) { width: 5%; }
            th:nth-child(2), td:nth-child(2) { width: 25%; }
            th:nth-child(3), td:nth-child(3) { width: 30%; }
            th:nth-child(4), td:nth-child(4) { width: 10%; }
            th:nth-child(5), td:nth-child(5) { width: 15%; }
            th:nth-child(6), td:nth-child(6) { width: 15%; }

            /* Mengatur lebar kolom dan word wrap */
            .name-column {
                width: 20%; /* Atur lebar kolom nama */
                word-wrap: break-word; /* Memungkinkan teks berpindah ke baris baru jika tidak muat */
            }

            .description-column {
                width: 30%; /* Atur lebar kolom deskripsi */
                word-wrap: break-word;
            }

            .qty-column, .price-column, .total-column {
                width: 10%; /* Atur lebar kolom lainnya */
            }

            /* Sesuaikan padding dan margin untuk memastikan konten tidak terpotong */
            .page {
                padding: 40px !important; /* Sesuaikan padding jika perlu */
                margin: auto;
            }

            /* Periksa dan sesuaikan ukuran font dan baris jika diperlukan */
            body, html {
                font-size: 10pt; /* Sesuaikan ukuran font */
                line-height: 1.5;
            }
        </style>
    </head>
    <body>
        <div class="page">
            <div class="header">
                <div class="logo-section">
                    <div class="logo-container">
                        <img src="{{ public_path('asset/logo2.png') }}" alt="logo" class="logo-image">
                        <!-- <img src="{{ asset('asset/logo2.png') }}" alt="logo" class="logo-image"> -->
                    </div>
                </div>
                <div class="invoice-section">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-info">
                        Invoice: #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}<br>
                        Tanggal: {{ date('d/m/Y', strtotime($invoice->date)) }}
                    </div>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NAME</th>
                        <th >DESCRIPTION</th>
                        <th>QTY</th>
                        <th>PRICE</th>
                        <th>TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                                @foreach($invoice->item as $index => $item)
                    <tr>
                        <td >{{ $index + 1 }}</td>
                        <td >{{ $item->name }}</td>
                        <td >{{ $item->description }}</td>
                        <td >{{ $item->quantity }}</td>
                        @if($item->is_dollar)
                            <td>$ {{ number_format($item->price_dollar, 2) }}</td>
                            <td>$ {{ number_format($item->amount_dollar, 2) }}</td>
                        @else
                            <td>Rp {{ number_format($item->price_rupiah, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($item->amount_rupiah, 0, ',', '.') }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="info-totals-container">
                <div class="billing-info">
                    <h3>Tagihan Kepada</h3>
                    <p>{{ $invoice->customer->nama }}</p>
                    <p>Telp: {{ $invoice->customer->phone }}</p>
                    <p>Email: {{ $invoice->customer->email }}</p>
                </div>
                <div class="totals">
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
                        <tr>
                            <td colspan="2" style="font-size: 11px; color: #636e72;">
                                Exchange Rate: 1 USD = Rp {{ number_format($invoice->current_dollar, 0, ',', '.') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="message">
                <h3>Pesan</h3>
                <p>Silahkan transfer ke rekening:<br>
                {{ $settings['payment_bank'] ?? 'BRI' }} {{ $settings['payment_account'] ?? '398329283298' }} a/n {{ $settings['payment_name'] ?? 'Wahyu' }}</p>
                <div class="underline"></div>
                <p>This is a computer-generated document. No signature is required.<br>
                Generated on {{ date('d/m/Y H:i:s') }}<p>
            </div>
        </div>
    </body>

    </html>
