<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Models\Invoice;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action as FormAction;
use Illuminate\Support\Facades\Http;
use App\Models\Settings;
use Filament\Forms\Get;
use App\Filament\Resources\InvoiceResource\Actions\GeneratePdfAction;
use App\Filament\Resources\InvoiceResource\Actions\SendInvoiceAction;
use App\Filament\Resources\InvoiceResource\Actions\BulkActions;
use Filament\Forms\Components\Group;
use Illuminate\Contracts\View\View;


class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;
    protected static ?string $navigationIcon = "heroicon-o-rectangle-stack";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make("Invoice Details")
                ->description("Enter invoice information")
                ->icon("heroicon-o-document-text")
                ->schema(static::getInvoiceDetailsSchema()),

                Section::make("Items")
                ->description("Add invoice items")
                ->icon("heroicon-o-shopping-cart")
                ->schema([
                    Repeater::make("items")
                        ->relationship("item")
                        ->schema([
                            TextInput::make("name")
                                ->required()
                                ->live()
                                ->columnSpan(2),
                            TextInput::make("description")->columnSpan(2),
                            Select::make('is_dollar')
                                ->label('Currency')
                                ->options([
                                    0 => 'IDR',
                                    1 => 'USD'
                                ])
                                ->default(0)
                                ->columnSpan(1),
                            TextInput::make("quantity")
                                ->default(1)
                                ->live(onBlur: true)
                                ->numeric()
                                ->minValue(1)
                                ->required()
                                ->suffix("unit")
                                ->afterStateUpdated(fn ($state, callable $set, Get $get) => 
                                    static::calculateAmounts($state, $set, $get)
                                ),
                            TextInput::make("price_rupiah")
                                ->label("Harga (IDR)")
                                ->columnSpan(2)
                                ->hidden(fn (Get $get) => $get('is_dollar'))
                                ->live(onBlur: true)
                                ->numeric()
                                ->prefix("Rp")
                                ->afterStateUpdated(fn ($state, callable $set, Get $get) => 
                                    static::calculatePrices($state, $set, $get, 'rupiah')
                                ),
                            TextInput::make("price_dollar")
                                ->label("Harga (USD)")
                                ->hidden(fn (Get $get) => !$get('is_dollar'))
                                ->live(onBlur: true)
                                ->numeric()
                                ->columnSpan(2)
                                ->prefix('$')
                                ->afterStateUpdated(fn ($state, callable $set, Get $get) => 
                                    static::calculatePrices($state, $set, $get, 'dollar')
                                ),
                            TextInput::make("amount_rupiah")
                                ->label("Total (IDR)")
                                ->disabled()
                                ->dehydrated()
                                ->prefix("Rp"),
                            TextInput::make("amount_dollar")
                                ->label("Total (USD)")
                                ->disabled()
                                ->dehydrated()
                                ->prefix("$"),
                        ])
                        ->defaultItems(1)
                        ->columnSpanFull()
                        ->columns(8)
                        ->collapsible()
                        ->cloneable()
                        ->itemLabel(fn(array $state): ?string => $state["name"] ?? null),
                ]),
        ]);
        }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make("customer.nama")
                    ->label("Customer Name")
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg')
                    ->translateLabel(),

                TextColumn::make("invoice_date")
                    ->label("Invoice Date")
                    ->date("d/m/Y")
                    ->sortable()
                    ->color('gray')
                    ->translateLabel(),

                TextColumn::make("item_count")
                    ->label("Total Items")
                    ->counts("item")
                    ->sortable()
                    ->alignCenter()
                    ->size('lg'),

                TextColumn::make("item.amount_rupiah")
                    ->label("Amount (IDR/USD)")
                    ->description(fn (Invoice $record): string => 
                        static::getAmountDescription($record)
                    )
                    ->formatStateUsing(fn ($state, Invoice $record) =>
                        static::formatAmount($record)
                    )
                    ->size('l')
                    ->color('success')
                    ->sortable(
                        query: function (
                            Builder $query,
                            string $direction
                        ): Builder {
                            return $query->orderByRaw(
                                "(SELECT SUM(amount_rupiah) FROM items WHERE items.invoice_id = invoices.id) " .
                                    $direction
                            );
                        }
                    ),

                TextColumn::make('status')
                    ->badge()
                    ->size('lg')
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'cancelled' => 'danger',
                        default => 'warning',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'paid' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-clock',
                    })
                    ->sortable(),

                TextColumn::make("due_date")
                    ->label("Due Date")
                    ->date("d/m/Y")
                    ->sortable()
                    ->color('gray')
                    ->translateLabel(),

                TextColumn::make("current_dollar")
                    ->label("Exchange Rate")
                    ->formatStateUsing(fn ($state) => $state ? "Rp. " . number_format($state, 0, ",", ".") : "-")
                    ->visible(function (?Invoice $record): bool {
                        if (!$record) return false;
                        return $record->is_dollar;
                    })
                    ->size('sm'),

                TextColumn::make("created_at")
                    ->label("Created")
                    ->dateTime("d/m/Y H:i")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make("updated_at")
                    ->label("Last Updated")
                    ->dateTime("d/m/Y H:i")
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->striped()
            ->defaultSort('invoice_date', 'desc')
            ->poll('60s')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalContent(fn ($record): View => view('filament.resources.invoice.modal.view', [
                        'invoice' => $record,
                    ]))
                    ->modalSubmitAction(false)
                    ->modalCancelAction(false)
                    ->modalWidth('5xl')
                    ->icon("heroicon-o-eye")
                    ->color('info')
                    ->tooltip('View')
                    ->label('')
                    ->size('md')
                    ->form([]),
                
                Tables\Actions\EditAction::make()
                    ->icon("heroicon-o-pencil")
                    ->color('info')
                    ->tooltip('Edit')
                    ->label('')
                    ->size('md'),
                
                GeneratePdfAction::make()
                    ->icon("heroicon-o-document-arrow-down")
                    ->color('success')
                    ->tooltip('PDF')
                    ->label('')
                    ->size('md'),
                
                SendInvoiceAction::make()
                    ->icon("heroicon-o-paper-airplane")
                    ->color('primary')
                    ->tooltip('Send')
                    ->label('')
                    ->size('md'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make(
                    array_merge(
                        [Tables\Actions\DeleteBulkAction::make()->icon('heroicon-o-trash')],
                        BulkActions::getBulkActions()
                    )
                ),
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
            "index" => Pages\ListInvoices::route("/"),
            "create" => Pages\CreateInvoice::route("/create"),
            "edit" => Pages\EditInvoice::route("/{record}/edit"),
        ];
    }

    protected static function calculateAmounts($quantity, callable $set, Get $get): void
    {
        $price_rupiah = (float)($get('price_rupiah') ?? 0);
        $price_dollar = (float)($get('price_dollar') ?? 0);
        
        $amount_rupiah = $price_rupiah * $quantity;
        $amount_dollar = $price_dollar * $quantity;
        
        $set('amount_rupiah', $amount_rupiah);
        $set('amount_dollar', $amount_dollar);
    }

    protected static function calculatePrices($price, callable $set, Get $get, string $type): void
    {
        $current_dollar = (float)$get('../../current_dollar');
        $quantity = max(1, (int)$get('quantity'));

        if ($price <= 0 || $current_dollar <= 0) {
            return;
        }

        if ($type === 'rupiah') {
            $price_dollar = round($price / $current_dollar, 2);
            static::setPrices($set, $price, $price_dollar, $quantity);
        } else {
            $price_rupiah = round($price * $current_dollar);
            static::setPrices($set, $price_rupiah, $price, $quantity);
        }
    }

    private static function setPrices(callable $set, float $price_rupiah, float $price_dollar, int $quantity): void
    {
        $set('price_rupiah', $price_rupiah);
        $set('price_dollar', $price_dollar);
        $set('amount_rupiah', $price_rupiah * $quantity);
        $set('amount_dollar', $price_dollar * $quantity);
    }

    protected static function getAmountDescription(Invoice $record): string 
    {
        if (!$record->is_dollar) {
            return "";
        }
        $total_dollar = $record->item()->sum("amount_dollar");
        return $total_dollar > 0 
            ? "$ " . number_format($total_dollar, 2)
            : "";
    }

    protected static function formatAmount(Invoice $record): string
    {
        $total_rupiah = $record->item()->sum("amount_rupiah");
        return "Rp. " . number_format($total_rupiah, 0, ",", ".");
    }

    protected static function getInvoiceDetailsSchema(): array
    {
        return [
            Group::make()
                ->schema([
                    Select::make("customer_id")
                        ->relationship("customer", "nama")
                        ->createOptionForm([
                            TextInput::make("nama")->required(),
                            TextInput::make("email")->email()->required(),
                            TextInput::make("phone")->tel()->required()
                        ])
                        ->searchable()
                        ->preload()
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($customer = \App\Models\Customer::find($state)) {
                                $set("email_reciver", $customer->email);
                            }
                        }),
                    TextInput::make("email_reciver")
                        ->live(onBlur: true)
                        ->placeholder(function ($get) {
                            $customer = \App\Models\Customer::find($get("customer_id"));
                            return $customer ? $customer->email : "";
                        })
                        ->label("Email Penerima")
                        ->email()
                        ->required()
                        ->columnSpan(1),
                ])
                ->columns(2),
            Group::make()
                ->schema([
                    DatePicker::make("invoice_date")
                        ->default(now())
                        ->required()
                        ->displayFormat("d/m/Y")
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $dueDate = \Carbon\Carbon::parse($state)->addDays(7);
                            $set("due_date", $dueDate);
                        })
                        ->columnSpan(1),
                    DatePicker::make("due_date")
                        ->required()
                        ->displayFormat("d/m/Y")
                        ->minDate(now())
                        ->default(now()->addDays(7))
                        ->columnSpan(1),
                    Select::make('status')
                        ->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid', 
                            'cancelled' => 'Cancelled'
                        ])
                        ->native(false)
                        ->default('pending')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make("current_dollar")
                        ->label("Kurs USD")
                        ->prefix('$')
                        ->numeric()
                        ->default(Settings::get('current_dollar'))
                        ->afterStateHydrated(function (callable $set) {
                            $set("current_dollar", Settings::get('current_dollar'));
                        })
                        ->live(onBlur: true)
                        ->required()
                        ->columnSpan(1)
                        ->afterStateUpdated(function (callable $set, $state) {
                            Settings::set('current_dollar', $state);
                        })
                        ->suffixAction(
                            FormAction::make("fetch_kurs")
                                ->icon("heroicon-m-arrow-path")
                                ->action(function (callable $set) {
                                    $response = Http::get(
                                        "https://v6.exchangerate-api.com/v6/08350a93548cd0baa01331b9/latest/USD"
                                    );

                                    if ($response->successful()) {
                                        $data = $response->json();
                                        $rate = $data["conversion_rates"]["IDR"];
                                        Settings::set('current_dollar', $rate);
                                        $set("current_dollar", $rate);
                                        Notification::make()
                                            ->title("Kurs Updated")
                                            ->success()
                                            ->send();
                                    }
                                })
                        )
                ])
                ->columns(4),
        ];
    }
}
