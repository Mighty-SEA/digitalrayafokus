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
use Filament\Forms\Components\Textarea;

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
            'current_dollar' => Settings::get('current_dollar'),
            'company_moto' => Settings::get('company_moto'),
            'company_vision' => Settings::get('company_vision'),
            'company_description' => Settings::get('company_description'),
            'company_social_media' => Settings::get('company_social_media'),
        ];
        
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main Information')
                    ->schema([
                        Section::make('Company Bio')
                            ->schema([
                                TextInput::make('company_name')
                                    ->label('Company Name')
                                    ->columnSpan(1),
                                FileUpload::make('company_logo')
                                    ->label('Company Logo')
                                    ->image()
                                    ->directory('company-logos')
                                    ->columnSpan(1),
                                Textarea::make('company_description')
                                    ->label('Company Description')
                                    ->autosize()
                                    ->columnSpan(2),
                                Textarea::make('company_moto')
                                    ->label('Company Moto')
                                    ->autosize()
                                    ->columnSpan(1),
                                Textarea::make('company_vision')
                                    ->label('Company Vision')
                                    ->autosize()
                                    ->columnSpan(1),
                            ])
                            ->columns(2),
                        Section::make('Company Contact')
                            ->schema([
                                Textarea::make('company_address')
                                    ->label('Company Address')
                                    ->autosize()
                                    ->columnSpan(2),
                                Textarea::make('company_social_media')
                                    ->label('Company Social Media')
                                    ->json()
                                    ->autosize()
                                    ->columnSpan(2),
                            ])
                            ->columns(2),
                    ])
                    ->columns(1),
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
