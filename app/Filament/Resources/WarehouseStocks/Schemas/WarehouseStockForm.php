<?php

namespace App\Filament\Resources\WarehouseStocks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WarehouseStockForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
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
                                    ->relationship('warehouseLocation', 'code')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('quantity')
                                    ->label(__('Quantity'))
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                                DateTimePicker::make('last_updated_at')
                                    ->label(__('Last Updated At'))
                                    ->required()
                                    ->default(now()),
                            ]),
                    ]),
            ]);
    }
}
