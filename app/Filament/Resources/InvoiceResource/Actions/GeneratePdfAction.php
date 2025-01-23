<?php

namespace App\Filament\Resources\InvoiceResource\Actions;

use App\Models\Invoice;
use App\Models\Settings;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class GeneratePdfAction
{
    public static function make(): Action
    {
        return Action::make('generate_pdf')
            ->label('Generate PDF')
            ->icon('heroicon-o-document')
            ->color('success')
            ->action(function (Invoice $record) {
                $record->customer->nama = mb_convert_encoding($record->customer->nama, 'UTF-8', 'auto');
                $record->item->each(function ($item) {
                    $item->description = mb_convert_encoding($item->description, 'UTF-8', 'auto');
                });

                $pdf = Pdf::loadView('invoices.pdf', [
                    'invoice' => $record,
                    'settings' => [
                        'name' => Settings::get('company_name'),
                        'email' => Settings::get('company_email'),
                        'phone' => Settings::get('company_phone'),
                        'address' => Settings::get('company_address'),
                        'logo' => Settings::get('company_logo'),
                        'payment_bank' => Settings::get('payment_bank'),
                        'payment_account' => Settings::get('payment_account'),
                        'payment_name' => Settings::get('payment_name'),
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
            });
    }
} 