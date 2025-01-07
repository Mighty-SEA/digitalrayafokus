<?php

namespace App\Filament\Resources\InvoiceResource\Actions;

use Filament\Tables\Actions\BulkAction;
use Filament\Forms\Components\Select;
use ZipArchive;
use App\Models\Settings;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BulkActions
{
    public static function getBulkActions(): array
    {
        return [
            BulkAction::make('generate_multiple_pdfs')
                ->label('Generate PDFs')
                ->icon('heroicon-o-document-duplicate')
                ->color('success')
                ->action(function ($records) {
                    // If only one record is selected, generate single PDF
                    if ($records->count() === 1) {
                        $record = $records->first();
                        $pdf = Pdf::loadView('invoices.pdf', [
                            'invoice' => $record,
                            'settings' => [
                                'name' => Settings::get('company_name'),
                                'email' => Settings::get('company_email'),
                                'phone' => Settings::get('company_phone'),
                                'address' => Settings::get('company_address'),
                                'logo' => Settings::get('company_logo'),
                            ],
                        ]);

                        return response()->stream(
                            function () use ($pdf) {
                                echo $pdf->output();
                            },
                            200,
                            [
                                'Content-Type' => 'application/pdf',
                                'Content-Disposition' => 'attachment; filename="' . $record->id . '-' . $record->customer->nama . '.pdf"',
                            ]
                        );
                    }

                    // For multiple records, create ZIP file
                    $zip = new ZipArchive();
                    $zipFileName = 'invoices-' . now()->format('Y-m-d-H-i-s') . '.zip';
                    $zipPath = storage_path('app/temp/' . $zipFileName);

                    if (!Storage::exists('temp')) {
                        Storage::makeDirectory('temp');
                    }

                    if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
                        foreach ($records as $record) {
                            $pdf = Pdf::loadView('invoices.pdf', [
                                'invoice' => $record,
                                'settings' => [
                                    'name' => Settings::get('company_name'),
                                    'email' => Settings::get('company_email'),
                                    'phone' => Settings::get('company_phone'),
                                    'address' => Settings::get('company_address'),
                                    'logo' => Settings::get('company_logo'),
                                ],
                            ]);

                            $pdfContent = $pdf->output();
                            $pdfFileName = $record->id . '-' . $record->customer->nama . '.pdf';
                            $zip->addFromString($pdfFileName, $pdfContent);
                        }
                        $zip->close();

                        return response()->download($zipPath)->deleteFileAfterSend();
                    }

                    Notification::make()
                        ->title('Error')
                        ->body('Failed to create ZIP file')
                        ->danger()
                        ->send();
                }),

            BulkAction::make('send_multiple_invoices')
                ->label('Send Invoices')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->action(function ($records) {
                    $successCount = 0;
                    $failCount = 0;

                    foreach ($records as $record) {
                        try {
                            $pdf = Pdf::loadView('invoices.pdf', [
                                'invoice' => $record,
                                'settings' => [
                                    'name' => Settings::get('company_name'),
                                    'email' => Settings::get('company_email'),
                                    'phone' => Settings::get('company_phone'),
                                    'address' => Settings::get('company_address'),
                                    'logo' => Settings::get('company_logo'),
                                ],
                            ]);

                            $pdfPath = storage_path('app/invoices/' . $record->id . '-' . $record->customer->nama . '.pdf');
                            $pdf->save($pdfPath);

                            Mail::to($record->email_reciver)->send(new InvoiceMail($record));
                            
                            // Delete PDF after sending email
                            if (File::exists($pdfPath)) {
                                File::delete($pdfPath);
                                Log::info('PDF deleted successfully after bulk send: ' . $pdfPath);
                            }
                            
                            $successCount++;

                        } catch (\Exception $e) {
                            // Delete PDF even if email fails
                            if (isset($pdfPath) && File::exists($pdfPath)) {
                                File::delete($pdfPath);
                                Log::info('PDF deleted after bulk send failure: ' . $pdfPath);
                            }
                            
                            Log::error('Failed to send invoice: ' . $e->getMessage());
                            $failCount++;
                        }
                    }

                    Notification::make()
                        ->title('Invoices Sent')
                        ->body("Successfully sent {$successCount} invoices. Failed to send {$failCount} invoices.")
                        ->success()
                        ->send();
                }),

            BulkAction::make('updateStatus')
                ->label('Update Status')
                ->icon('heroicon-o-check-circle')
                ->color('info')
                ->form([
                    Select::make('status')
                        ->label('Select Status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'cancelled' => 'Cancelled',
                        ])
                        ->native(false)
                        ->required()
                ])
                ->action(function ($records, array $data) {
                    foreach ($records as $record) {
                        $record->update(['status' => $data['status']]);
                    }

                    Notification::make()
                        ->title('Status Updated')
                        ->body('Selected invoices have been updated successfully.')
                        ->success()
                        ->send();
                }),
        ];
    }
} 