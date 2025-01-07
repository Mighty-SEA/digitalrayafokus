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
                    Select::make("customer_id")
                        ->relationship("customer", "nama")
                        ->createOptionForm([
                            TextInput::make("nama")->required(),
                            TextInput::make("email")->email()->required(),
                            TextInput::make("phone")->tel()->required(),
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
                        ->columnSpan(2),
                    TextInput::make("email_reciver")
                        ->live(onBlur: true)
                        ->placeholder(function ($get) {
                            $customer = \App\Models\Customer::find(
                                $get("customer_id")
                            );
                            return $customer ? $customer->email : "";
                        })
                        ->label("Email Penerima")
                        ->email()
                        ->required()
                        ->columnSpan(2),
                    DatePicker::make("invoice_date")
                        ->default(now())
                        ->required()
                        ->displayFormat("d/m/Y")
                        ->live()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $dueDate = \Carbon\Carbon::parse($state)->addDays(
                                7
                            );
                            $set("due_date", $dueDate);
                        }),
                    DatePicker::make("due_date")
                        ->required()
                        ->displayFormat("d/m/Y")
                        ->minDate(now())
                        ->default(now()->addDays(7)),
                    TextInput::make("current_dollar")
                        ->label("Kurs USD")
                        ->prefix('$')
                        ->numeric()
                        ->default(Usd::find(1)->dollar)
                        ->afterStateHydrated(function (callable $set) {
                            $usd = Usd::find(1);
                            if ($usd) {
                                $set("current_dollar", $usd->dollar);
                            }
                        })
                        ->live(onBlur: true)
                        ->required()
                        ->afterStateUpdated(function (callable $set, $state) {
                            $usd = Usd::find(1);
                            if ($usd) {
                                $usd->dollar = $state;
                                $usd->save();
                            }
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
                                        $rate =
                                            $data["conversion_rates"]["IDR"];

                                        $usd = Usd::find(1);
                                        $usd->dollar = $rate;
                                        $usd->save();

                                        $set("current_dollar", $rate);

                                        Notification::make()
                                            ->title("Kurs Updated")
                                            ->success()
                                            ->send();
                                    }
                                })
                        ),
                ])
                ->columns(6),

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
                            TextInput::make("quantity")
                                ->default(1)
                                ->live(onBlur: true)
                                ->numeric()
                                ->minValue(1)
                                ->required()
                                ->suffix("unit")
                                ->afterStateUpdated(function (
                                    callable $set,
                                    $state,
                                    $get
                                ) {
                                    $priceRupiah = $get("price_rupiah") ?? 0;
                                    $amount = $priceRupiah * $state;
                                    $set("amount_rupiah", $amount);
                                }),
                            TextInput::make("price_rupiah")
                                ->label("Harga (IDR)")
                                ->live(onBlur: true)
                                ->required()
                                ->numeric()
                                ->prefix("Rp")
                                ->afterStateUpdated(function (
                                    callable $set,
                                    $state,
                                    $get
                                ) {
                                    $usd = Usd::find(1);
                                    if ($usd && $usd->dollar != 0) {
                                        $set(
                                            "price_dollar",
                                            $state / $usd->dollar
                                        );
                                    } else {
                                        $set("price_dollar", 0);
                                    }
                                    $quantity = $get("quantity") ?? 1;
                                    $amountRupiah = $state * $quantity;
                                    $set("amount_rupiah", $amountRupiah);
                                    $set(
                                        "amount_dollar",
                                        $usd ? $amountRupiah / $usd->dollar : 0
                                    );
                                }),
                            TextInput::make("price_dollar")
                                ->label("Harga (USD)")
                                ->live(onBlur: true)
                                ->numeric()
                                ->prefix('$')
                                ->afterStateUpdated(function (
                                    callable $set,
                                    $state,
                                    $get
                                ) {
                                    $usd = Usd::find(1);
                                    if ($usd && $usd->dollar != 0) {
                                        $set(
                                            "price_rupiah",
                                            $state * $usd->dollar
                                        );
                                    } else {
                                        $set("price_rupiah", 0);
                                    }
                                    $quantity = $get("quantity") ?? 1;
                                    $amountDollar = $state * $quantity;
                                    $set("amount_dollar", $amountDollar);
                                    $set(
                                        "amount_rupiah",
                                        $usd ? $amountDollar * $usd->dollar : 0
                                    );
                                }),
                            TextInput::make("amount_rupiah")
                                ->label("Total (IDR)")
                                ->prefix("Rp")
                                ->default(0),
                            TextInput::make("amount_dollar")
                                ->label("Total (USD)")
                                ->prefix('$'),
                        ])
                        ->defaultItems(1)
                        ->columnSpanFull()
                        ->columns(8)
                        ->collapsible()
                        ->cloneable()
                        ->itemLabel(
                            fn(array $state): ?string => $state["name"] ?? null
                        ),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->icon("heroicon-o-pencil"),
                Action::make("generate_pdf")
                    ->label("Generate PDF")
                    ->icon("heroicon-o-document")
                    ->color("success")
                    ->action(function (Invoice $record) {
                        $record->customer->nama = mb_convert_encoding(
                            $record->customer->nama,
                            "UTF-8",
                            "auto"
                        );
                        $record->item->each(function ($item) {
                            $item->description = mb_convert_encoding(
                                $item->description,
                                "UTF-8",
                                "auto"
                            );
                        });

                        $pdf = Pdf::loadView("invoices.pdf", [
                            "invoice" => $record,
                            "settings" => [
                                "name" => Settings::get('company_name'),
                                "email" => Settings::get('company_email'),
                                "phone" => Settings::get('company_phone'),
                                "address" => Settings::get('company_address'),
                                "logo" => Settings::get('company_logo'),
                            ],
                        ]);

                        return response()->stream(
                            function () use ($pdf) {
                                echo $pdf->output();
                            },
                            200,
                            [
                                "Content-Type" => "application/pdf",
                                "Content-Disposition" =>
                                    'attachment; filename="' .
                                    $record->id .
                                    "-" .
                                    $record->customer->nama .
                                    '.pdf"',
                            ],
                            Notification::make()
                                ->title("PDF Generated")
                                ->body(
                                    "The PDF has been generated successfully."
                                )
                                ->success()
                                ->sendToDatabase(Auth::user())
                                ->send()
                        );
                    }),
                Action::make("send_invoice")
                    ->label("Send Invoice")
                    ->icon("heroicon-o-paper-airplane")
                    ->color("primary")
                    ->action(function (Invoice $record) {
                        $pdf = Pdf::loadView("invoices.pdf", [
                            "invoice" => $record,
                            "settings" => [
                                "name" => Settings::get('company_name'),
                                "email" => Settings::get('company_email'),
                                "phone" => Settings::get('company_phone'),
                                "address" => Settings::get('company_address'),
                                "logo" => Settings::get('company_logo'),
                            ],
                        ])
                            ->setOption("isHtml5ParserEnabled", true)
                            ->setOption("isPhpEnabled", true)
                            ->setOption("defaultFont", "DejaVu Sans");

                        $pdfPath = storage_path(
                            "app/invoices/" .
                                $record->id .
                                "-" .
                                $record->customer->nama .
                                ".pdf"
                        );
                        $pdf->save($pdfPath);

                        if (!file_exists($pdfPath)) {
                            Log::error("PDF was not saved at " . $pdfPath);
                            return Notification::make()
                                ->title("Error")
                                ->body("Failed to generate PDF.")
                                ->danger()
                                ->send();
                        }

                        try {
                            Mail::to($record->customer->email)->send(
                                new InvoiceMail($record)
                            );

                            return Notification::make()
                                ->title("Invoice Sent")
                                ->body(
                                    "The invoice has been successfully sent to " .
                                        $record->customer->email
                                )
                                ->success()
                                ->sendToDatabase(Auth::user())
                                ->send();
                            return redirect()->back();
                        } catch (\Exception $e) {
                            Log::error(
                                "Failed to send invoice: " . $e->getMessage()
                            );
                            return Notification::make()
                                ->title("Error Sending Invoice")
                                ->body(
                                    "There was an error sending the invoice: " .
                                        $e->getMessage()
                                )
                                ->danger()
                                ->sendToDatabase(Auth::user())
                                ->send();
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkActionGroup::make([]),
                    Tables\Actions\DeleteBulkAction::make()->icon(
                        "heroicon-o-trash"
                    ),
                    BulkAction::make("generate_multiple_pdfs")
                        ->label("Generate PDFs")
                        ->icon("heroicon-o-document-duplicate")
                        ->color("success")
                        ->action(function ($records) {
                            $zip = new ZipArchive();
                            $zipFileName = storage_path(
                                "app/bulk_invoices.zip"
                            );

                            if (
                                $zip->open(
                                    $zipFileName,
                                    ZipArchive::CREATE | ZipArchive::OVERWRITE
                                ) === true
                            ) {
                                foreach ($records as $record) {
                                    $record->customer->nama = mb_convert_encoding(
                                        $record->customer->nama,
                                        "UTF-8",
                                        "auto"
                                    );
                                    $record->item->each(function ($item) {
                                        $item->description = mb_convert_encoding(
                                            $item->description,
                                            "UTF-8",
                                            "auto"
                                        );
                                    });

                                    $pdf = Pdf::loadView("invoices.pdf", [
                                        "invoice" => $record,
                                        "settings" => [
                                            "name" => Settings::get('company_name'),
                                            "email" => Settings::get('company_email'),
                                            "phone" => Settings::get('company_phone'),
                                            "address" => Settings::get('company_address'),
                                            "logo" => Settings::get('company_logo'),
                                        ],
                                    ]);

                                    $pdfContent = $pdf->output();
                                    $zip->addFromString(
                                        $record->id .
                                            "-" .
                                            $record->customer->nama .
                                            ".pdf",
                                        $pdfContent
                                    );
                                }
                                $zip->close();

                                return response()
                                    ->download($zipFileName)
                                    ->deleteFileAfterSend();
                            }

                            return Notification::make()
                                ->title("Error")
                                ->body("Failed to create ZIP file")
                                ->danger()
                                ->send();
                        }),
                    BulkAction::make("send_multiple_invoices")
                        ->label("Send Invoices")
                        ->icon("heroicon-o-paper-airplane")
                        ->color("primary")
                        ->action(function ($records) {
                            $successCount = 0;
                            $failCount = 0;

                            foreach ($records as $record) {
                                try {
                                    $pdf = Pdf::loadView("invoices.pdf", [
                                        "invoice" => $record,
                                        "settings" => [
                                            "name" => Settings::get('company_name'),
                                            "email" => Settings::get('company_email'),
                                            "phone" => Settings::get('company_phone'),
                                            "address" => Settings::get('company_address'),
                                            "logo" => Settings::get('company_logo'),
                                        ],
                                    ])
                                        ->setOption(
                                            "isHtml5ParserEnabled",
                                            true
                                        )
                                        ->setOption("isPhpEnabled", true)
                                        ->setOption(
                                            "defaultFont",
                                            "DejaVu Sans"
                                        );

                                    $pdfPath = storage_path(
                                        "app/invoices/" .
                                            $record->id .
                                            "-" .
                                            $record->customer->nama .
                                            ".pdf"
                                    );
                                    $pdf->save($pdfPath);

                                    Mail::to($record->customer->email)->send(
                                        new InvoiceMail($record)
                                    );

                                    $successCount++;
                                } catch (\Exception $e) {
                                    Log::error(
                                        "Failed to send invoice: " .
                                            $e->getMessage()
                                    );
                                    $failCount++;
                                }
                            }

                            return Notification::make()
                                ->title("Bulk Invoice Sending Complete")
                                ->body(
                                    "Successfully sent {$successCount} invoices, {$failCount} failed."
                                )
                                ->success()
                                ->sendToDatabase(Auth::user())
                                ->send();
                        }),
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
            "index" => Pages\ListInvoices::route("/"),
            "create" => Pages\CreateInvoice::route("/create"),
            "edit" => Pages\EditInvoice::route("/{record}/edit"),
        ];
    }
}
