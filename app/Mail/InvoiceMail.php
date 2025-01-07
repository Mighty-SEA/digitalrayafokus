<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use App\Models\Invoice;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Settings;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    /**
     * Create a new message instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(subject: "Invoice #" . $this->invoice->id);
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: "invoices.send",
            with: [
                "invoice" => $this->invoice,
                "settings" => [
                    'name' => Settings::get('company_name'),
                    'email' => Settings::get('company_email'),
                    'phone' => Settings::get('company_phone'),
                    'address' => Settings::get('company_address'),
                    'logo' => Settings::get('company_logo'),
                ]
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            \Illuminate\Mail\Mailables\Attachment::fromPath(
                storage_path(
                    "app/invoices/" .
                        $this->invoice->id .
                        "-" .
                        $this->invoice->customer->nama .
                        ".pdf"
                )
            ),
        ];
    }
}
