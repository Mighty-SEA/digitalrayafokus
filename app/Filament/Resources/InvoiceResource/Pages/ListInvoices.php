<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Exports\InvoiceExporter;
use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()->exporter(InvoiceExporter::class)
        ];
    }
}
