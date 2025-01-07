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
                    // Existing generate multiple PDFs logic
                }),

            BulkAction::make('send_multiple_invoices')
                ->label('Send Invoices')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->action(function ($records) {
                    // Existing send multiple invoices logic
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
                    // Existing update status logic
                }),
        ];
    }
} 