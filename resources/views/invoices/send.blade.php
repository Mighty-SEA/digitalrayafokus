<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Notification</title>
    <style>
        body {
            font-family: 'Helvetica', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            margin: 0;
            padding: 0;
            background-color: #f7fafc;
        }

        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: #2d3748;
            color: white;
            padding: 30px;
            text-align: center;
        }

        .content {
            padding: 30px;
        }

        .invoice-details {
            background: #f8fafc;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }

        .button {
            display: inline-block;
            background: #4299e1;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #718096;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Invoice #{{ str_pad($invoice->id, 6, '0', STR_PAD_LEFT) }}</h1>
        </div>

        <div class="content">
            <p>Dear {{ $invoice->customer->nama }},</p>

            <p>Thank you for your business. Please find attached the invoice for your recent transaction.</p>

            <div class="invoice-details">
                <p><strong>Invoice Date:</strong> {{ date('d F Y', strtotime($invoice->invoice_date)) }}</p>
                <p><strong>Due Date:</strong> {{ date('d F Y', strtotime($invoice->due_date)) }}</p>
                <p><strong>Total Amount:</strong> 
                    {{ $invoice->is_dollar ? '$' : 'Rp' }} 
                    {{ number_format(
                        $invoice->is_dollar 
                            ? $invoice->item->sum('amount_dollar') 
                            : $invoice->item->sum('amount_rupiah'),
                        $invoice->is_dollar ? 2 : 0, 
                        $invoice->is_dollar ? '.' : ',',
                        $invoice->is_dollar ? ',' : '.'
                    ) }}
                </p>
            </div>

            <p>Please review the attached invoice and process the payment before the due date.</p>

            <a href="{{ route('invoices.pay', $invoice->id) }}" class="button">View Invoice & Pay Now</a>

            <p>If you have any questions or concerns, please don't hesitate to contact us.</p>

            <p>Best regards,<br>{{ $settings['name'] }}</p>
        </div>

        <div class="footer">
            <p>This is an automated email. Please do not reply directly to this message.</p>
        </div>
    </div>
</body>
</html>
