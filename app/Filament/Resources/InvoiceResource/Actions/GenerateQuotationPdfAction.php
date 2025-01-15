<?php

namespace App\Filament\Resources\InvoiceResource\Actions;

use App\Models\Settings;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class GenerateQuotationPdfAction extends Action
{
    public static function getDefaultName(): ?string 
    {
        return 'generateQuotation';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->icon('heroicon-o-document')
            ->color('warning')
            ->label('')
            ->tooltip('Buat Penawaran')
            ->action(function ($record) {
                $pdf = Pdf::loadView('invoices.quotation', [
                    'invoice' => $record,
                    'settings' => [
                        'name' => Settings::get('company_name'),
                        'email' => Settings::get('company_email'),
                        'phone' => Settings::get('company_phone'),
                        'address' => Settings::get('company_address'),
                        'logo' => Settings::get('company_logo'),
                    ],
                    'date' => Carbon::now(),
                ]);

                return response()->streamDownload(function () use ($pdf) {
                    echo $pdf->output();
                }, "Penawaran-{$record->id}.pdf");
            });
    }
} 