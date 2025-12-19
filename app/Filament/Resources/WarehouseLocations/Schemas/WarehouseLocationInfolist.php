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
                                TextEntry::make('code')
                                    ->label(__('Code'))
                                    ->weight('bold')
                                    ->copyable(),
                                TextEntry::make('status')
                                    ->label(__('Status'))
                                    ->badge()
                                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive'))
                                    ->color(fn(bool $state): string => $state ? 'success' : 'danger'),
                            ]),
                    ]),

                Section::make(__('Location Details'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextEntry::make('section')
                                    ->label(__('Section'))
                                    ->placeholder('-'),
                                TextEntry::make('rack')
                                    ->label(__('Rack'))
                                    ->placeholder('-'),
                                TextEntry::make('shelf')
                                    ->label(__('Shelf'))
                                    ->placeholder('-'),
                            ]),
                    ]),

                Section::make(__('Additional Information'))
                    ->schema([
                        TextEntry::make('notes')
                            ->label(__('Notes'))
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
