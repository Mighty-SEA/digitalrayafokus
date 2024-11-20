<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use function Laravel\Prompts\select;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customer_id')
                    ->relationship('customer', 'nama')
                    ->createOptionForm([
                        TextInput::make('nama'),
                        TextInput::make('email'),
                        TextInput::make('phone')
                    ])
                    ->searchable(),
                TextInput::make('email_reciver')
                    ->label('email penerima'),
                DatePicker::make('invoice_date')
                    ->default(now()),
                DatePicker::make('due_date'),

                //saya ingin dibawah ini default dollar update secara otomatis misal dollar 1 dolar sekarang adalah 15919.90
                TextInput::make('dollar')
                    ->placeholder('15919.90')
                    ->default('15919.90'),

                Repeater::make('items')
                    ->relationship('item')
                    ->schema([
                        TextInput::make('name'),
                        TextInput::make('description'),
                        TextInput::make('quantity'),
                        TextInput::make('rupiah'),
                        TextInput::make('dollar'),
                        TextInput::make('amount_rupiah'),
                        TextInput::make('amount_dollar')
                    ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.nama'),
                TextColumn::make('item.name'),
                TextColumn::make('item.amount_rupiah')
                ->description(function (Invoice $record): string {
                    // Access the first related item to fetch the amount_dollar
                    $item = $record->item()->first(); // Get the first related item
                    return $item ? $item->amount_dollar : ''; // Display the amount_dollar or empty if not found
                })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
