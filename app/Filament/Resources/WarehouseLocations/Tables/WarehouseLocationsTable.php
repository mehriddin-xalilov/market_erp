<?php

namespace App\Filament\Resources\WarehouseLocations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WarehouseLocationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('section')
                    ->label(__('Section'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rack')
                    ->label(__('Rack'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('shelf')
                    ->label(__('Shelf'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->formatStateUsing(fn(bool $state): string => $state ? __('Active') : __('Inactive'))
                    ->color(fn(bool $state): string => $state ? 'success' : 'danger')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('Status'))
                    ->options([
                        true => __('Active'),
                        false => __('Inactive'),
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                CreateAction::make()
                    ->label(__('Create')),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
