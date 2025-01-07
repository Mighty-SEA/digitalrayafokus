<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;
use App\Models\Settings;

class ManageSettings extends ManageRecords
{
    protected static string $resource = SettingsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Setting')
                ->modalHeading('Add New Setting'),
        ];
    }

    public function mount(): void
    {
        $defaultSettings = [
            'company_name' => '',
            'company_email' => '',
            'company_phone' => '',
            'company_address' => '',
            'company_logo' => '',
        ];

        foreach ($defaultSettings as $key => $value) {
            Settings::firstOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}