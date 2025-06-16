<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatbotFaqResource\Pages;
use App\Models\ChatbotFaq;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatbotFaqResource extends Resource
{
    protected static ?string $model = ChatbotFaq::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Chatbot Management';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('answer')
                    ->required()
                    ->columnSpanFull()
                    ->rows(5),
                Forms\Components\Textarea::make('keywords')
                    ->helperText('Masukkan kata kunci yang terkait dengan pertanyaan ini, pisahkan dengan koma')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->options([
                        'umum' => 'Umum',
                        'layanan' => 'Layanan',
                        'harga' => 'Harga',
                        'kontak' => 'Kontak',
                        'teknis' => 'Teknis',
                    ])
                    ->searchable(),
                Forms\Components\TextInput::make('priority')
                    ->numeric()
                    ->default(0)
                    ->helperText('Semakin tinggi nilainya, semakin tinggi prioritasnya'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Aktif')
                    ->helperText('Apakah FAQ ini aktif dan ditampilkan?'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('priority')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'umum' => 'Umum',
                        'layanan' => 'Layanan',
                        'harga' => 'Harga',
                        'kontak' => 'Kontak',
                        'teknis' => 'Teknis',
                    ]),
                Tables\Filters\SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Aktif',
                        '0' => 'Tidak Aktif',
                    ]),
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
            'index' => Pages\ListChatbotFaqs::route('/'),
            'create' => Pages\CreateChatbotFaq::route('/create'),
            'edit' => Pages\EditChatbotFaq::route('/{record}/edit'),
        ];
    }
} 