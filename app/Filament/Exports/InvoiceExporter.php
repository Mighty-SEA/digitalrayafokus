<?php

namespace App\Filament\Exports;

use App\Models\Invoice;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class InvoiceExporter extends Exporter
{
    protected static ?string $model = Invoice::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('customer.nama')
                ->label('Customer Name'),
            ExportColumn::make('customer_id'),
            ExportColumn::make('invoice_date'),
            ExportColumn::make('due_date'),
            ExportColumn::make('email_reciver'),
            ExportColumn::make('is_dollar'),
            ExportColumn::make('current_dollar'),
            ExportColumn::make('status'),
            ExportColumn::make('item_total_idr')
                ->label('Amount (IDR)')
                ->state(function (Invoice $record): string {
                    return number_format($record->item()->sum('amount_rupiah'), 0, ',', '.');
                }),
            ExportColumn::make('item_total_usd')
                ->label('Amount (USD)')
                ->state(function (Invoice $record): string {
                    return number_format($record->item()->sum('amount_dollar'), 2, '.', ',');
                }),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your invoice export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
