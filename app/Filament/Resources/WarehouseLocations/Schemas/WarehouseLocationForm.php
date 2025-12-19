<?php

namespace App\Filament\Resources\WarehouseLocations\Schemas;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WarehouseLocationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Basic Information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->label(__('Code'))
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Masalan: A-01-01'),
                                Toggle::make('status')
                                    ->label(__('Status'))
                                    ->required()
                                    ->inline(false)
                                    ->onColor('success')
                                    ->offColor('danger'),
                            ]),
                    ]),

                Section::make(__('Location Details'))
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('section')
                                    ->label(__('Section'))
                                    ->maxLength(255)
                                    ->placeholder('A'),
                                TextInput::make('rack')
                                    ->label(__('Rack'))
                                    ->maxLength(255)
                                    ->placeholder('01'),
                                TextInput::make('shelf')
                                    ->label(__('Shelf'))
                                    ->maxLength(255)
                                    ->placeholder('01'),
                            ]),
                    ]),

                Section::make(__('Additional Information'))
                    ->schema([
                        Textarea::make('notes')
                            ->label(__('Notes'))
                            ->columnSpanFull()
                            ->rows(3)
                            ->placeholder('Qo\'shimcha izohlar...'),
                    ]),
            ]);
    }
}
