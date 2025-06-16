<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChatbotConversationResource\Pages;
use App\Models\ChatbotConversation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;

class ChatbotConversationResource extends Resource
{
    protected static ?string $model = ChatbotConversation::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Chatbot Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('session_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('user_id')
                    ->numeric(),
                Forms\Components\Textarea::make('user_message')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('bot_response')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('source')
                    ->options([
                        'php' => 'PHP',
                        'python' => 'Python',
                    ])
                    ->required(),
                Forms\Components\Select::make('sentiment')
                    ->options([
                        'positive' => 'Positive',
                        'negative' => 'Negative',
                        'neutral' => 'Neutral',
                    ]),
                Forms\Components\KeyValue::make('processed_data')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('session_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user_message')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('bot_response')
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('source')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sentiment')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'php' => 'PHP',
                        'python' => 'Python',
                    ]),
                Tables\Filters\SelectFilter::make('sentiment')
                    ->options([
                        'positive' => 'Positive',
                        'negative' => 'Negative',
                        'neutral' => 'Neutral',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\TextEntry::make('session_id'),
                Infolists\Components\TextEntry::make('user_id'),
                Infolists\Components\TextEntry::make('user_message')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('bot_response')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('source'),
                Infolists\Components\TextEntry::make('sentiment'),
                Infolists\Components\KeyValueEntry::make('processed_data')
                    ->columnSpanFull(),
                Infolists\Components\TextEntry::make('created_at')
                    ->dateTime(),
                Infolists\Components\TextEntry::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListChatbotConversations::route('/'),
            'create' => Pages\CreateChatbotConversation::route('/create'),
            'edit' => Pages\EditChatbotConversation::route('/{record}/edit'),
            'view' => Pages\ViewChatbotConversation::route('/{record}'),
        ];
    }
} 