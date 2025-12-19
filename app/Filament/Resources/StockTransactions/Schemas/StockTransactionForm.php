<?php

namespace App\Filament\Resources\StockTransactions\Schemas;

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
                Section::make(__('Basic Information'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                Select::make('user_id')
                                    ->label(__('User'))
                                    ->relationship('user', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('reference_no')
                                    ->label(__('Reference No'))
                                    ->maxLength(255),
                                Select::make('type')
                                    ->label(__('Type'))
                                    ->options([
                                        1 => __('In'),
                                        2 => __('Out'),
                                    ])
                                    ->required()
                                    ->live(),
                            ]),
                    ]),

                Section::make(__('Transaction Details'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->label(__('Product'))
                                    ->relationship('product', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                                        $type = $get('type');
                                        $locationId = $get('warehouse_location_id');

                                        if ($type == 2) {
                                            if ($locationId) {
                                                $query->whereHas('warehouseStocks', function ($q) use ($locationId) {
                                                    $q->where('warehouse_location_id', $locationId)
                                                        ->where('quantity', '>', 0);
                                                });
                                            } else {
                                                $query->whereHas('warehouseStocks', function ($q) {
                                                    $q->where('quantity', '>', 0);
                                                });
                                            }
                                        }
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $locationId = $get('warehouse_location_id');
                                        if ($locationId && $state) {
                                            $exists = WarehouseStock::where('warehouse_location_id', $locationId)
                                                ->where('product_id', $state)
                                                ->where('quantity', '>', 0)
                                                ->exists();
                                            if (! $exists) {
                                                $set('warehouse_location_id', null);
                                            }
                                        }
                                    }),
                                Select::make('warehouse_location_id')
                                    ->label(__('Warehouse Location'))
                                    ->relationship('warehouseLocation', 'code', modifyQueryUsing: function (Builder $query, Get $get) {
                                        $type = $get('type');
                                        $productId = $get('product_id');

                                        if ($type == 2) {
                                            if ($productId) {
                                                $query->whereHas('warehouseStocks', function ($q) use ($productId) {
                                                    $q->where('product_id', $productId)
                                                        ->where('quantity', '>', 0);
                                                });
                                            } else {
                                                $query->whereHas('warehouseStocks', function ($q) {
                                                    $q->where('quantity', '>', 0);
                                                });
                                            }
                                        }
                                    })
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                        $productId = $get('product_id');
                                        if ($productId && $state) {
                                            $exists = WarehouseStock::where('warehouse_location_id', $state)
                                                ->where('product_id', $productId)
                                                ->where('quantity', '>', 0)
                                                ->exists();
                                            if (! $exists) {
                                                $set('product_id', null);
                                            }
                                        }
                                    }),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextInput::make('quantity')
                                    ->label(__('Quantity'))
                                    ->required()
                                    ->numeric(),
                                TextInput::make('unit_price')
                                    ->label(__('Unit Price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                                TextInput::make('total_price')
                                    ->label(__('Total Price'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                            ]),
                    ]),

                Section::make(__('Additional Information'))
                    ->schema([
                        Textarea::make('notes')
                            ->label(__('Notes'))
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
