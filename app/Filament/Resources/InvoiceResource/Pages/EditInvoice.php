<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
{
    return 'User updated';
}

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        Notification::make()
        ->title('Saved successfully')
        ->sendToDatabase(auth()->user());
        return $record;

    }
}
