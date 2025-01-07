<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationLabel = 'Settings';
    protected static bool $shouldRegisterNavigation = false; // Hide from sidebar

    public static function form(Form $form): Form
    {
        return $form->schema([
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
                ->columns(2),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditSettings::route('/'),
        ];
    }
}
