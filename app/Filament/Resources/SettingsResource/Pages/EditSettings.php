<?php

namespace App\Filament\Resources\SettingsResource\Pages;

use App\Filament\Resources\SettingsResource;
use Filament\Resources\Pages\Page;
use App\Models\Settings;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Notifications\Notification;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class EditSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingsResource::class;
    protected static string $view = 'filament.resources.settings-resource.pages.edit-settings';
    public ?array $data = [];

    public function mount(): void
    {
        $settings = [
            'company_name' => Settings::get('company_name'),
            'company_email' => Settings::get('company_email'),
            'company_phone' => Settings::get('company_phone'),
            'company_address' => Settings::get('company_address'),
            'company_logo' => Settings::get('company_logo'),
        ];
        
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Company Information')
                    ->schema([
                        TextInput::make('company_name')
                            ->label('Company Name')
                            ->required(),
                        TextInput::make('company_email')
                            ->label('Company Email')
                            ->email()
                            ->required(),
                        TextInput::make('company_phone')
                            ->label('Company Phone')
                            ->tel(),
                        TextInput::make('company_address')
                            ->label('Company Address')
                            ->columnSpan('full'),
                        FileUpload::make('company_logo')
                            ->label('Company Logo')
                            ->image()
                            ->directory('company-logos'),
                    ])
                    ->columns(2)
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Settings::set($key, $value);
        }

        Notification::make()
            ->title('Settings saved successfully')
            ->success()
            ->send();
    }
}
