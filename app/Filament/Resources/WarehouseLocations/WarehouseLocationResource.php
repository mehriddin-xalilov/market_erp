<?php

namespace App\Filament\Resources\WarehouseLocations;

use App\Filament\Resources\WarehouseLocations\Pages\CreateWarehouseLocation;
use App\Filament\Resources\WarehouseLocations\Pages\EditWarehouseLocation;
use App\Filament\Resources\WarehouseLocations\Pages\ListWarehouseLocations;
use App\Filament\Resources\WarehouseLocations\Pages\ViewWarehouseLocation;
use App\Filament\Resources\WarehouseLocations\Schemas\WarehouseLocationForm;
use App\Filament\Resources\WarehouseLocations\Schemas\WarehouseLocationInfolist;
use App\Filament\Resources\WarehouseLocations\Tables\WarehouseLocationsTable;
use App\Models\WarehouseLocation;
use BackedEnum;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;

class WarehouseLocationResource extends Resource
{
    protected static ?string $model = WarehouseLocation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static ?string $recordTitleAttribute = 'code';

    public static function getNavigationLabel(): string
    {
        return __('Warehouse Locations');
    }

    public static function getModelLabel(): string
    {
        return __('Warehouse Location');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Warehouse Locations');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        Components\TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Components\TextInput::make('address')
                            ->label(__('Address'))
                            ->maxLength(255),
                        Components\Toggle::make('status')
                            ->label(__('Status'))
                            ->required()
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return WarehouseLocationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WarehouseLocationsTable::configure($table)
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label(__('Status'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWarehouseLocations::route('/'),
            'create' => CreateWarehouseLocation::route('/create'),
            'view' => ViewWarehouseLocation::route('/{record}'),
            'edit' => EditWarehouseLocation::route('/{record}/edit'),
        ];
    }
}
