<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Mail\InvoiceMail;
use App\Models\Companies;
use App\Models\Invoice;
use App\Models\Item;
use App\Models\Usd;
use Barryvdh\DomPDF\Facade\Pdf;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use ZipArchive;
use Filament\Forms\Components\Actions\Action as FormAction;
use Illuminate\Support\Facades\Http;
use App\Models\Settings;
use Filament\Forms\Get;
use App\Filament\Resources\InvoiceResource\Actions\GeneratePdfAction;
use App\Filament\Resources\InvoiceResource\Actions\SendInvoiceAction;
use App\Filament\Resources\InvoiceResource\Actions\BulkActions;
use Filament\Forms\Components\Group;

use function Laravel\Prompts\select;

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
                ->schema([
                    // Customer Information Group
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
                                    $customer = \App\Models\Customer::find($state);
                                    if ($customer) {
                                        $set("email_reciver", $customer->email);
                                    }
                                })
                                ->columnSpan(3),

                            TextInput::make("email_reciver")
                                ->live(onBlur: true)
                                ->placeholder(function ($get) {
                                    $customer = \App\Models\Customer::find($get("customer_id"));
                                    return $customer ? $customer->email : "";
                                })
                                ->label("Email Penerima")
                                ->email()
                                ->required()
                                ->columnSpan(3),
                        ])
                        ->columns(6),

                    // Dates and Currency Group
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
                                ->columnSpan(2),

                            DatePicker::make("due_date")
                                ->required()
                                ->displayFormat("d/m/Y")
                                ->minDate(now())
                                ->default(now()->addDays(7))
                                ->columnSpan(2),

                            Select::make('status')
                                ->options([
                                    'pending' => 'Pending',
                                    'paid' => 'Paid',
                                    'cancelled' => 'Cancelled'
                                ])
                                ->native(false)
                                ->default('pending')
                                ->required()
                                ->columnSpan(2),
                        ])
                        ->columns(6),

                    // Currency Settings
                    Group::make()
                        ->schema([
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
                                ->columnSpan(4),

                            Select::make('is_dollar')
                                ->label('Currency')
                                ->options([
                                    '0' => 'IDR (Rupiah)',
                                    '1' => 'USD (Dollar)'
                                ])
                                ->default('0')
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $set('is_dollar', $state === 'usd');
                                })
                                ->columnSpan(2),

                            // Hidden field untuk is_dollar
                            Toggle::make('is_dollar')
                                ->hidden()
                                ->default(false)
                                ->dehydrated(),
                        ])
                        ->columns(6),
                ])
                ->columns(1),

            // Items Section
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
                                ->columnSpan(3),
                            TextInput::make("description")
                                ->columnSpan(3),
                            TextInput::make("quantity")
                                ->default(1)
                                ->live(onBlur: true)
                                ->numeric()
                                ->minValue(1)
                                ->required()
                                ->suffix("unit")
                                ->columnSpan(2),
                            TextInput::make("price_rupiah")
                                ->label("Harga (IDR)")
                                ->live(onBlur: true)
                                ->required()
                                ->numeric()
                                ->prefix("Rp")
                                ->afterStateUpdated(function (callable $set, $state, $get) {
                                    $usd = Settings::get('current_dollar');
                                    if ($usd && $usd != 0) {
                                        $set("price_dollar", $state / $usd);
                                    } else {
                                        $set("price_dollar", 0);
                                    }
                                    $quantity = $get("quantity") ?? 1;
                                    $amountRupiah = $state * $quantity;
                                    $set("amount_rupiah", $amountRupiah);
                                    $set("amount_dollar", $usd ? $amountRupiah / $usd : 0);
                                })
                                ->columnSpan(3),
                            TextInput::make("price_dollar")
                                ->label("Harga (USD)")
                                ->live(onBlur: true)
                                ->numeric()
                                ->prefix('$')
                                ->hidden(fn (Get $get) => !$get('../../is_dollar'))
                                ->columnSpan(3),
                            TextInput::make("amount_rupiah")
                                ->label("Total (IDR)")
                                ->prefix("Rp")
                                ->disabled()
                                ->default(0)
                                ->columnSpan(3),
                            TextInput::make("amount_dollar")
                                ->label("Total (USD)")
                                ->prefix('$')
                                ->disabled()
                                ->hidden(fn (Get $get) => !$get('../../is_dollar'))
                                ->columnSpan(3),
                        ])
                        ->defaultItems(1)
                        ->columnSpanFull()
                        ->columns(12)
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
                    ->sortable(),
                TextColumn::make("invoice_date")
                    ->label("Invoice Date")
                    ->date("d/m/Y")
                    ->sortable(),
                TextColumn::make("item_count")
                    ->label("Total Items")
                    ->counts("item")
                    ->sortable(),
                TextColumn::make("item.amount_rupiah")
                    ->label("Amount (IDR/USD)")
                    ->description(function (Invoice $record): string {
                        $total_dollar = $record->item()->sum("amount_dollar");
                        return $total_dollar > 0
                            ? "$ " . number_format($total_dollar, 2)
                            : "";
                    })
                    ->formatStateUsing(function ($state, Invoice $record) {
                        $total_rupiah = $record->item()->sum("amount_rupiah");
                        return "Rp. " .
                            number_format($total_rupiah, 0, ",", ".");
                    })
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
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'cancelled' => 'danger',
                        default => 'warning',
                    })
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->icon("heroicon-o-pencil"),
                GeneratePdfAction::make(),
                SendInvoiceAction::make(),
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
}
