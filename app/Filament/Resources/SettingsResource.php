<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingsResource\Pages;
use App\Models\Settings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class SettingsResource extends Resource
{
    protected static ?string $model = Settings::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Perusahaan')
                    ->schema([
                        Forms\Components\TextInput::make('company_name')
                            ->label('Nama Perusahaan')
                            ->required(),
                        Forms\Components\FileUpload::make('company_logo')
                            ->label('Logo Perusahaan')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                        Forms\Components\Textarea::make('company_description')
                            ->label('Deskripsi Perusahaan')
                            ->rows(3),
                        Forms\Components\Textarea::make('company_visi')
                            ->label('Visi Perusahaan')
                            ->rows(3),
                        Forms\Components\Textarea::make('company_misi')
                            ->label('Misi Perusahaan')
                            ->rows(4),
                    ]),
                
                Forms\Components\Section::make('Kontak & Lokasi')
                    ->schema([
                        Forms\Components\TextInput::make('company_address')
                            ->label('Alamat')
                            ->columnSpan('full'),
                        Forms\Components\TextInput::make('company_email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\TextInput::make('company_phone')
                            ->label('Telepon'),
                    ]),

                Forms\Components\Section::make('SEO & Branding')
                    ->schema([
                        Forms\Components\TextInput::make('company_tagline')
                            ->label('Tagline'),
                        Forms\Components\Textarea::make('company_keywords')
                            ->label('Keywords SEO')
                            ->rows(2),
                    ]),

                Forms\Components\Section::make('Konten Beranda')
                    ->schema([
                        Forms\Components\TextInput::make('tc1')
                            ->label('Judul Hero Section'),
                        Forms\Components\TextInput::make('dc1')
                            ->label('Deskripsi Hero Section'),
                        Forms\Components\FileUpload::make('ic1')
                            ->label('Gambar Hero')
                            ->image()
                            ->disk('public')
                            ->directory('settings'),
                        Forms\Components\TextInput::make('tc2')
                            ->label('Judul Section 2'),
                        Forms\Components\TextInput::make('dc2')
                            ->label('Deskripsi Section 2'),
                    ]),

                Forms\Components\Section::make('judul halaman')
                    ->schema([
                        Forms\Components\TextInput::make('pt1')
                            ->label('halaman 1'),
                        Forms\Components\TextInput::make('pt2')
                            ->label('halaman 2'),
                        Forms\Components\TextInput::make('pt3')
                            ->label('halaman 3'),
                        Forms\Components\TextInput::make('pt4')
                            ->label('halaman 4'),
                        Forms\Components\TextInput::make('pt5')
                            ->label('halaman 5'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('value')
                    ->visible(fn ($record) => $record && $record->type === 'image'),
                Tables\Columns\TextColumn::make('value')
                    ->visible(fn ($record) => $record && $record->type === 'text')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        if ($record && $record->type === 'image' && $record->value) {
                            Storage::disk('public')->delete($record->value);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            if ($records) {
                                foreach ($records as $record) {
                                    if ($record && $record->type === 'image' && $record->value) {
                                        Storage::disk('public')->delete($record->value);
                                    }
                                }
                            }
                        }),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\EditSettings::route('/'),
        ];
    }
}
