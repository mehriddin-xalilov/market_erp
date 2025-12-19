<?php

namespace App\Filament\Resources\WarehouseStocks\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class WarehouseStockInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label(__('Product'))
                                    ->weight('bold'),
                                TextEntry::make('warehouseLocation.code')
                                    ->label(__('Warehouse Location')),
                                TextEntry::make('quantity')
                                    ->label(__('Quantity')),
                                TextEntry::make('last_updated_at')
                                    ->label(__('Last Updated At'))
                                    ->dateTime(),
                            ]),
                    ]),
                Section::make(__('System Information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('created_at')
                                    ->label(__('Created At'))
                                    ->dateTime()
                                    ->placeholder('-'),
                                TextEntry::make('updated_at')
                                    ->label(__('Updated At'))
                                    ->dateTime()
                                    ->placeholder('-'),
                            ]),
                    ])
                    ->collapsed(),
            ]);
    }
}
