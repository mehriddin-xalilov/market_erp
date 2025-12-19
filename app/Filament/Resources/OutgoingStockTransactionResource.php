<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OutgoingStockTransactionResource\Pages\CreateStockTransaction;
use App\Filament\Resources\OutgoingStockTransactionResource\Pages\EditStockTransaction;
use App\Filament\Resources\OutgoingStockTransactionResource\Pages\ListStockTransactions;
use App\Filament\Resources\OutgoingStockTransactionResource\Pages\ViewStockTransaction;
use App\Filament\Resources\OutgoingStockTransactionResource\Schemas\StockTransactionForm;
use App\Filament\Resources\OutgoingStockTransactionResource\Schemas\StockTransactionInfolist;
use App\Filament\Resources\OutgoingStockTransactionResource\Tables\StockTransactionsTable;
use Illuminate\Database\Eloquent\Builder;
use App\Models\StockTransaction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OutgoingStockTransactionResource extends Resource
{
    protected static ?string $model = StockTransaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedArrowUpTray;
    protected static ?string $recordTitleAttribute = 'reference_no';

    public static function getNavigationLabel(): string
    {
        return __('Chiqim');
    }

    public static function getModelLabel(): string
    {
        return __('Chiqim');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Chiqimlar');
    }

    public static function form(Schema $schema): Schema
    {
        return StockTransactionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StockTransactionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StockTransactionsTable::configure($table)
            ->modifyQueryUsing(fn(Builder $query) => $query->where('type', 2));
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
            'index' => ListStockTransactions::route('/'),
            'create' => CreateStockTransaction::route('/create'),
            'view' => ViewStockTransaction::route('/{record}'),
            'edit' => EditStockTransaction::route('/{record}/edit'),
        ];
    }
}
