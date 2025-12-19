<?php

namespace App\Filament\Resources\WarehouseLocations\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;

class WarehouseLocationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label(__('Name'))
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('status')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive'))
                                    ->color(fn(bool $state): string => $state ? 'success' : 'danger'),
                            ]),
                        TextEntry::make('address')
                            ->label(__('Address'))
                            ->placeholder('-')
                            ->columnSpanFull(),
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
