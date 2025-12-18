<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Mahsulot nomi')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->wrap(),

                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('SKU nusxalandi')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('category.name')
                    ->label('Kategoriya')
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('price')
                    ->label('Sotuv narxi')
                    ->money('UZS')
                    ->sortable()
                    ->alignEnd(),

                TextColumn::make('cost_price')
                    ->label('Tan narxi')
                    ->money('UZS')
                    ->sortable()
                    ->alignEnd()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('current_stock')
                    ->label('Zaxira')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(
                        fn(int $state, $record): string =>
                        $state == 0 ? 'danger' : ($state <= $record->reorder_level ? 'warning' : 'success')
                    ),

                TextColumn::make('unit')
                    ->label('Birlik')
                    ->searchable()
                    ->badge()
                    ->color('gray'),

                IconColumn::make('status')
                    ->label('Holat')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                TextColumn::make('created_at')
                    ->label('Yaratilgan')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('O\'zgartirilgan')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Kategoriya')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('status')
                    ->label('Holat')
                    ->placeholder('Hammasi')
                    ->trueLabel('Faol')
                    ->falseLabel('Nofaol'),

                SelectFilter::make('stock_level')
                    ->label('Zaxira holati')
                    ->options([
                        'out_of_stock' => 'Tugagan',
                        'low_stock' => 'Kam',
                        'in_stock' => 'Yetarli',
                    ])
                    ->query(function ($query, $state) {
                        if ($state['value'] === 'out_of_stock') {
                            return $query->where('current_stock', 0);
                        }
                        if ($state['value'] === 'low_stock') {
                            return $query->whereColumn('current_stock', '<=', 'reorder_level')
                                ->where('current_stock', '>', 0);
                        }
                        if ($state['value'] === 'in_stock') {
                            return $query->whereColumn('current_stock', '>', 'reorder_level');
                        }
                        return $query;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
