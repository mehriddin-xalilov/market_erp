<?php

namespace App\Filament\Resources\StockTransactions\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

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
                                    ->required(),
                            ]),
                    ]),

                Section::make(__('Transaction Details'))
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
