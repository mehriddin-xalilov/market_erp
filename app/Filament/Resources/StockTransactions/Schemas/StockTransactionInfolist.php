<?php

namespace App\Filament\Resources\StockTransactions\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class StockTransactionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('reference_no')
                                    ->label(__('Reference No'))
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('user.name')
                                    ->label(__('User')),
                                TextEntry::make('type')
                                    ->label(__('Type'))
                                    ->badge()
                                    ->formatStateUsing(fn(int $state): string => match ($state) {
                                        1 => __('In'),
                                        2 => __('Out'),
                                        default => (string) $state,
                                    })
                                    ->color(fn(int $state): string => match ($state) {
                                        1 => 'success',
                                        2 => 'danger',
                                        default => 'gray',
                                    }),
                            ]),
                    ]),

                Section::make(__('Transaction Details'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label(__('Product')),
                                TextEntry::make('warehouseLocation.name')
                                    ->label(__('Warehouse Location')),
                            ]),
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('quantity')
                                    ->label(__('Quantity')),
                                TextEntry::make('unit_price')
                                    ->label(__('Unit Price'))
                                    ->numeric(decimalPlaces: 0)
                                    ->suffix(' so\'m'),
                                TextEntry::make('total_price')
                                    ->label(__('Total Price'))
                                    ->numeric(decimalPlaces: 0)
                                    ->suffix(' so\'m'),
                            ]),
                    ]),

                Section::make(__('Additional Information'))
                    ->schema([
                        TextEntry::make('notes')
                            ->label(__('Notes'))
                            ->columnSpanFull()
                            ->placeholder('-'),
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
