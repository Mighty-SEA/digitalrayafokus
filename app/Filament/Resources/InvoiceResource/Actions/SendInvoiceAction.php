<?php

namespace App\Filament\Resources\InvoiceResource\Actions;

use App\Models\Invoice;
use App\Models\Settings;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class SendInvoiceAction
{
    public static function make(): Action
    {
        return Action::make('send_invoice')
            ->label('Send Invoice')
            ->icon('heroicon-o-paper-airplane')
            ->color('primary')
            ->action(function (Invoice $record) {
                $pdf = Pdf::loadView('invoices.pdf', [
                    'invoice' => $record,
                    'settings' => [
                        'name' => Settings::get('company_name'),
                        'email' => Settings::get('company_email'),
                        'phone' => Settings::get('company_phone'),
                        'address' => Settings::get('company_address'),
                        'logo' => Settings::get('company_logo'),
                    ],
                ])
                    ->setOption('isHtml5ParserEnabled', true)
                    ->setOption('isPhpEnabled', true)
                    ->setOption('defaultFont', 'DejaVu Sans');

                $pdfPath = storage_path('app/invoices/' . $record->id . '-' . $record->customer->nama . '.pdf');

                $directory = dirname($pdfPath);
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true);
                }

                $pdf->save($pdfPath);

                if (!file_exists($pdfPath)) {
                    Log::error('PDF was not saved at ' . $pdfPath);
                    return Notification::make()
                        ->title('Error')
                        ->body('Failed to generate PDF.')
                        ->danger()
                        ->send();
                }

                try {
                    Mail::to($record->email_reciver)->send(
                        new InvoiceMail($record)
                    );

                    // Delete the PDF file after sending email
                    if (File::exists($pdfPath)) {
                        File::delete($pdfPath);
                        Log::info('PDF deleted successfully: ' . $pdfPath);
                    }

                    return Notification::make()
                        ->title('Invoice Sent')
                        ->body(
                            'The invoice has been successfully sent to ' .
                                $record->customer->email
                        )
                        ->success()
                        ->sendToDatabase(Auth::user())
                        ->send();
                } catch (\Exception $e) {
                    // Delete the PDF file even if email fails
                    if (File::exists($pdfPath)) {
                        File::delete($pdfPath);
                        Log::info('PDF deleted after email failure: ' . $pdfPath);
                    }

                    Log::error(
                        'Failed to send invoice: ' . $e->getMessage()
                    );
                    return Notification::make()
                        ->title('Error Sending Invoice')
                        ->body(
                            'There was an error sending the invoice: ' .
                                $e->getMessage()
                        )
                        ->danger()
                        ->sendToDatabase(Auth::user())
                        ->send();
                }
            });
    }
} 