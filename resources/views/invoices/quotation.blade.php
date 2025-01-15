<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Penawaran</title>
    <style>
        @page {
            size: A4;
            margin: 2.54cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            font-size: 11pt;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h2 {
            color: #2d3748;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #718096;
            margin: 5px 0 0;
        }
        .content {
            margin: 20px 0;
        }
        .customer-info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #4a5568;
            color: white;
            padding: 12px;
            font-weight: normal;
        }
        td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
        }
        .notes {
            margin: 20px 0;
        }
        .notes ul {
            list-style-type: none;
            padding-left: 0;
        }
        .notes li {
            margin: 8px 0;
            padding-left: 20px;
            position: relative;
        }
        .notes li:before {
            content: "•";
            color: #4a5568;
            position: absolute;
            left: 0;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #718096;
            width: 200px;
            margin-left: auto;
            margin-top: 50px;
        }
        .company-info {
            margin-top: 40px;
            text-align: center;
            color: #718096;
            font-size: 12px;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>SURAT PENAWARAN</h2>
        <p>No: QT-{{ $invoice->id }}/{{ date('Y/m') }}</p>
    </div>

    <div class="content">
        <div class="customer-info">
            <p><strong>Kepada Yth,</strong><br>
            Bapak/Ibu Pimpinan<br>
            {{ $invoice->customer->nama }}<br>
            {{ $invoice->customer->email }}</p>

            <p>Dengan hormat,<br>
            Terima kasih atas kepercayaan Bapak/Ibu kepada perusahaan kami. Menanggapi permintaan penawaran dari pihak Bapak/Ibu, dengan ini kami sampaikan penawaran harga untuk produk/jasa sebagai berikut:</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No</th>
                    <th style="width: 25%">Nama Item</th>
                    <th style="width: 30%">Deskripsi</th>
                    <th style="width: 10%">Qty</th>
                    <th style="width: 15%">Harga</th>
                    <th style="width: 15%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->item as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->description }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        @if($item->is_dollar)
                            $ {{ number_format($item->price_dollar, 2) }}
                        @else
                            Rp {{ number_format($item->price_rupiah, 0, ',', '.') }}
                        @endif
                    </td>
                    <td>
                        @if($item->is_dollar)
                            $ {{ number_format($item->amount_dollar, 2) }}
                        @else
                            Rp {{ number_format($item->amount_rupiah, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="notes">
            <p><strong>Ketentuan dan Persyaratan:</strong></p>
            <ul>
                <li>Masa berlaku penawaran: {{ $invoice->due_date ?  date('d/m/Y', strtotime($invoice->due_date)) : 'Tidak ada batas waktu' }}</li>
                <li>Harga yang tercantum sudah termasuk pajak yang berlaku</li>
                <li>Pembayaran dapat dilakukan melalui transfer bank ke rekening resmi perusahaan</li>
                <li>Spesifikasi dan kualitas produk sesuai dengan standar yang telah ditetapkan</li>
                <li>Pengiriman akan dilakukan setelah pembayaran diterima</li>
                <li>Garansi produk sesuai dengan ketentuan yang berlaku</li>
            </ul>
        </div>

        <p>Demikian surat penawaran ini kami sampaikan. Kami berharap penawaran yang kami ajukan dapat memenuhi kebutuhan dan harapan Bapak/Ibu. Apabila ada hal-hal yang perlu didiskusikan lebih lanjut, silakan menghubungi kami melalui kontak yang tertera.</p>
        
        <p>Atas perhatian dan kepercayaan Bapak/Ibu, kami mengucapkan terima kasih.</p>

        <div class="signature">
            <p>{{ $settings['city'] ?? 'Jakarta' }}, {{ date('d F Y') }}</p>
            <p>Hormat kami,</p>
            <div class="signature-line"></div>
            <p>{{ $settings['name'] ?? 'Nama Perusahaan' }}</p>
        </div>

        <div class="company-info">
            <p>
                {{ $settings['name'] ?? 'Nama Perusahaan' }} |
                {{ $settings['email'] ?? 'email@perusahaan.com' }} |
                {{ $settings['phone'] ?? 'Telepon' }}<br>
                {{ $settings['address'] ?? 'Alamat Perusahaan' }}
            </p>
        </div>
    </div>
</body>
</html> 