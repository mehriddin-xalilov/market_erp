<?php

namespace App\Filament\Resources\OutgoingStockTransactionResource\Schemas;

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
                    ->default(2),

                \Filament\Forms\Components\Repeater::make('items')
                    ->label(__('Items'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('product_id')
                                    ->label(__('Product'))
                                    ->relationship('product', 'name', modifyQueryUsing: function (Builder $query, Get $get) {
                                        $locationId = $get('warehouse_location_id');

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

                                        if ($state) {
                                            $product = \App\Models\Product::find($state);
                                            if ($product) {
                                                $set('unit_price', $product->price);
                                            }
                                        }
                                    }),
                                Select::make('warehouse_location_id')
                                    ->label(__('Warehouse Location'))
                                    ->relationship('warehouseLocation', 'code', modifyQueryUsing: function (Builder $query, Get $get) {
                                        $productId = $get('product_id');

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
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
