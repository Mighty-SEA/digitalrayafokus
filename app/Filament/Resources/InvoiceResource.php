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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use function Laravel\Prompts\select;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                Section::make()
                    ->schema([
                        Select::make('customer_id')
                        ->relationship('customer', 'nama')
                        ->createOptionForm([
                            TextInput::make('nama'),
                            TextInput::make('email'),
                            TextInput::make('phone')
                        ])
                        ->searchable(),
                    TextInput::make('email_reciver')->live(onBlur:true)
        
                        ->label('email penerima'),
                    DatePicker::make('invoice_date')
                        ->default(now()),
                    DatePicker::make('due_date'),
                    TextInput::make('current_dollar')
                        ->label('dolar saat ini')
                        ->default(Usd::find(1)->dollar)
                        ->afterStateHydrated(function (callable $set) {
                            $usd = Usd::find(1); // Fetch the dollar value from the database
                            if ($usd) {
                                $set('current_dollar', $usd->dollar); // Set the form field with the dollar value
                            }
                        })
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (callable $set, $state) {
                            // Sync the current dollar value back to the Usd model whenever it changes
                            $usd = Usd::find(1); // Assuming you only have one row for USD exchange rate
                            if ($usd) {
                                $usd->dollar = $state; // Update the dollar value in the Usd model
                                $usd->save(); // Save the new value
                            }
                        }),
                    ])->columns(5),
                Section::make()
                    ->schema([
                        Repeater::make('items')
                        ->relationship('item')
                        ->schema([  
                            TextInput::make('name')->live(),
                            TextInput::make('description'),
                            TextInput::make('quantity')
                                ->default(1)
                                ->live(onBlur:true)
                                ->numeric()
                                ->minValue(1)
                                ->afterStateUpdated(function (callable $set, $state, $get) {
                                    // Calculate amount_rupiah based on quantity and price_rupiah
                                    $priceRupiah = $get('price_rupiah');
                                    $set('amount_rupiah', $priceRupiah * $state); // quantity * price_rupiah
                                }),
                                TextInput::make('price_rupiah')
                                ->label('harga dalam rupiah')
                                ->live(onBlur:true)
                                ->afterStateUpdated(function (callable $set, $state, $get) {
                                    // Get the current dollar value from the Usd model (assuming one record with id=1)
                                    $usd = Usd::find(1); // Fetch the exchange rate from the USD table
                                    
                                    // Ensure the exchange rate exists
                                    if ($usd && $usd->dollar != 0) {
                                        // Calculate price_dollar as price_rupiah * usd->dollar
                                        $set('price_dollar', $state / $usd->dollar); // Multiply price_rupiah by the exchange rate
                                    } else {
                                        // Handle the case where the exchange rate is 0 or not found
                                        $set('price_dollar', 0); // Set to 0 if exchange rate is invalid
                                    }
                            
                                    // Calculate amount_rupiah based on price_rupiah and quantity
                                    $quantity = $get('quantity');
                                    $set('amount_rupiah', $state * $quantity); // Multiply price_rupiah by quantity
        
                                              // Calculate amount_dollar as amount_rupiah / usd->dollar
                                    $amountRupiah = $state * $quantity; // amount_rupiah is price_rupiah * quantity
                                    $set('amount_dollar', $amountRupiah / $usd->dollar); // Divide amount_rupiah by the exchange rate to get amount_dollar
                                }),
                                TextInput::make('price_dollar') // Automatically calculated
                                    ->label('harga dalam dolar'),
                                TextInput::make('amount_rupiah') // Automatically calculated
                                    ->disabled(),
                                TextInput::make('amount_dollar') // Assuming you want this to be calculated or entered manually
                            
                                ])->columnSpan(5)->columns(7)
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
                    // Ensure the description returns a string even when amount_dollar is null
                    return $item && $item->amount_dollar !== null ? (string) $item->amount_dollar : ''; // Return an empty string if no amount_dollar
                })  
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('generate_pdf')
                ->label('Generate PDF')
                ->action(function (Invoice $record){
                    //rubah format ke UTF 8
                    $record->customer->nama = mb_convert_encoding($record->customer->nama, 'UTF-8', 'auto');
                    $record->item->each(function($item){
                        $item->description = mb_convert_encoding($item->description, 'UTF-8', 'auto');
                    });

                    //generate pdf
                    $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $record, 'company' => Companies::find(1)]);

                    //download pdf
                    return response()->stream(function()use($pdf){
                        echo $pdf->output();
                    }, 200, [
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="invoice_'.$record->customer->id .'.pdf"'
                    ]);
                }),

                Action::make('send_invoice')
                ->label('Send Invoice')
                ->action(function (Invoice $record) {
                    // Generate PDF
                    $pdf = Pdf::loadView('invoices.pdf', ['invoice' => $record, 'company' => Companies::find(1)])
                              ->setOption('isHtml5ParserEnabled', true)
                              ->setOption('isPhpEnabled', true)
                              ->setOption('defaultFont', 'DejaVu Sans');
            
                    $pdfPath = storage_path('app/invoices/invoice_' . $record->customer->nama . '.pdf');
                    $pdf->save($pdfPath);
            
                    // Check if PDF was saved
                    if (!file_exists($pdfPath)) {
                        Log::error('PDF was not saved at ' . $pdfPath);
                        return \Filament\Notifications\Notification::make()
                            ->title('Error')
                            ->body('Failed to generate PDF.')
                            ->danger();
                    }
            
                    // Send email
                    try {
                        Mail::to($record->customer->email)->send(new InvoiceMail($record));
                        return \Filament\Notifications\Notification::make()
                            ->title('Invoice Sent')
                            ->body('The invoice has been successfully sent to ' . $record->customer->email)
                            ->success();
                    } catch (\Exception $e) {
                        Log::error('Failed to send invoice: ' . $e->getMessage());
                        return \Filament\Notifications\Notification::make()
                            ->title('Error Sending Invoice')
                            ->body('There was an error sending the invoice: ' . $e->getMessage())
                            ->danger();
                    }
                }),


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
