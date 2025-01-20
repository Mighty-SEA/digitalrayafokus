<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LayananResource\Pages;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Layanan')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Layanan')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (string $state, Forms\Set $set) => $set('slug', Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                        Forms\Components\Select::make('icon')
                            ->label('Icon')
                            ->required()
                            ->searchable()
                            ->options([
                                'fa-solid fa-laptop-code' => 'Laptop Code',
                                'fa-solid fa-code' => 'Code',
                                'fa-solid fa-server' => 'Server',
                                'fa-solid fa-network-wired' => 'Network',
                                'fa-solid fa-database' => 'Database',
                                'fa-solid fa-cloud' => 'Cloud',
                                'fa-solid fa-mobile-screen' => 'Mobile',
                                'fa-solid fa-desktop' => 'Desktop',
                                'fa-solid fa-gear' => 'Gear',
                                'fa-solid fa-shield' => 'Shield',
                                'fa-regular fa-handshake' => 'Handshake',
                                'fa-solid fa-graduation-cap' => 'Graduation Cap',
                                'fa-solid fa-list-check' => 'List Check',
                                'fa-solid fa-chart-line' => 'Chart Line',
                                'fa-solid fa-users' => 'Users',
                                'fa-solid fa-headset' => 'Headset',
                                'fa-solid fa-wrench' => 'Wrench',
                                'fa-solid fa-rocket' => 'Rocket',
                            ])
                            ->preload()
                            ->native(false)
                            ->columnSpanFull()
                            ->helperText('Pilih icon yang sesuai untuk layanan ini')
                            ->formatStateUsing(function ($state) {
                                return $state ?? 'fa-solid fa-gear';
                            })
                            ->selectablePlaceholder(false),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi')
                            ->required()
                            ->rows(3),
                        Forms\Components\TagsInput::make('features')
                            ->label('Fitur Layanan')
                            ->required(),
                        Forms\Components\TagsInput::make('benefits')
                            ->label('Keunggulan')
                            ->required(),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean(),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }
}
