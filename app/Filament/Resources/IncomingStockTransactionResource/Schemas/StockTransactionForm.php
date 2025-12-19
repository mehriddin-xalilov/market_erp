<?php

namespace App\Filament\Resources\IncomingStockTransactionResource\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use App\Models\WarehouseStock;

class StockTransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                \Filament\Forms\Components\Hidden::make('reference_no')
                    ->default(fn() => 'TRX-' . date('YmdHis')),
                \Filament\Forms\Components\Hidden::make('type')
                    ->default(1),

                Section::make(__('Transaction Details'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->label(__('Product'))
                                    ->relationship('product', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('warehouse_location_id')
                                    ->label(__('Warehouse Location'))
                                    ->relationship('warehouseLocation', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('quantity')
                                    ->label(__('Quantity'))
                                    ->required()
                                    ->numeric()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $unitPrice = $get('unit_price');
                                        if ($state && $unitPrice) {
                                            $set('total_price', $state * $unitPrice);
                                        }
                                    }),
                                TextInput::make('unit_price')
                                    ->label(__('Unit Price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Set $set, Get $get, $state) {
                                        $quantity = $get('quantity');
                                        if ($state && $quantity) {
                                            $set('total_price', $state * $quantity);
                                        }
                                    }),
                                TextInput::make('total_price')
                                    ->label(__('Total Price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$')
                                    ->readOnly(),
                            ]),
                        Textarea::make('notes')
                            ->label(__('Notes'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
