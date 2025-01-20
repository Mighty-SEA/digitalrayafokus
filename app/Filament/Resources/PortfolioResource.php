<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioResource\Pages;
use App\Models\Portfolio;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;

class PortfolioResource extends Resource
{
    protected static ?string $model = Portfolio::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    
    protected static ?string $navigationLabel = 'Portfolio';
    
    protected static ?string $modelLabel = 'Portfolio';
    
    protected static ?string $navigationGroup = 'Content';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('portfolio')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->maxSize(5120)
                    ->enableOpen()
                    ->enableDownload()
                    ->required(),
                FileUpload::make('image2')
                    ->image()
                    ->disk('public')
                    ->directory('portfolio')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->maxSize(5120)
                    ->enableOpen()
                    ->enableDownload()
                    ->nullable(),
                FileUpload::make('image3')
                    ->image()
                    ->disk('public')
                    ->directory('portfolio')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->maxSize(5120)
                    ->enableOpen()
                    ->enableDownload()
                    ->nullable(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('category')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('year')
                    ->required()
                    ->maxLength(4),
                Forms\Components\TextInput::make('link')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public')
                    ->size(100)
                    ->url(fn ($record) => $record->image ? Storage::url($record->image) : null)
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(fn(): array => Portfolio::distinct()->pluck('category', 'category')->toArray())
                    ->multiple()
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalWidth('lg'),
                Tables\Actions\DeleteAction::make()
                    ->modalWidth('sm')
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Portfolio dihapus')
                            ->body('Portfolio berhasil dihapus')
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalWidth('sm')
                        ->successNotification(
                            Notification::make()
                                ->success()
                                ->title('Portfolio dihapus')
                                ->body('Portfolio yang dipilih berhasil dihapus')
                        ),
                ]),
            ])
            ->poll('10s')
            ->striped()
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
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
            'index' => Pages\ListPortfolios::route('/'),
            'create' => Pages\CreatePortfolio::route('/create'),
            'edit' => Pages\EditPortfolio::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes()
            ->latest();
    }
}