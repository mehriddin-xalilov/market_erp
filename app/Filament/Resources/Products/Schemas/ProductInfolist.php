<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Support\Enums\IconSize;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Mahsulot ma\'lumotlari')
                    ->schema([
                        TextEntry::make('name')
                            ->label('Mahsulot nomi')
                            ->size('lg')
                            ->weight('bold')
                            ->columnSpanFull(),

                        TextEntry::make('sku')
                            ->label('SKU/Artikul')
                            ->copyable()
                            ->copyMessage('SKU nusxalandi')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('category.name')
                            ->label('Kategoriya')
                            ->badge()
                            ->color('info'),

                        TextEntry::make('unit')
                            ->label('O\'lchov birligi')
                            ->badge()
                            ->color('gray'),

                        TextEntry::make('description')
                            ->label('Tavsif')
                            ->placeholder('Tavsif kiritilmagan')
                            ->columnSpanFull()
                            ->markdown(),
                    ])
                    ->columns(3),

                Section::make('Narx ma\'lumotlari')
                    ->schema([
                        TextEntry::make('cost_price')
                            ->label('Tan narxi')
                            ->money('UZS')
                            ->size('lg'),

                        TextEntry::make('price')
                            ->label('Sotuv narxi')
                            ->money('UZS')
                            ->size('lg')
                            ->weight('bold')
                            ->color('success'),

                        TextEntry::make('profit')
                            ->label('Foyda')
                            ->state(fn($record) => $record->price - $record->cost_price)
                            ->money('UZS')
                            ->size('lg')
                            ->color(fn($state) => $state > 0 ? 'success' : 'danger'),
                    ])
                    ->columns(3),

                Section::make('Ombor ma\'lumotlari')
                    ->schema([
                        TextEntry::make('current_stock')
                            ->label('Joriy zaxira')
                            ->numeric()
                            ->badge()
                            ->size('lg')
                            ->color(
                                fn(int $state, $record): string =>
                                $state == 0 ? 'danger' : ($state <= $record->reorder_level ? 'warning' : 'success')
                            ),

                        TextEntry::make('reorder_level')
                            ->label('Minimal zaxira')
                            ->numeric()
                            ->badge()
                            ->color('gray'),

                        IconEntry::make('status')
                            ->label('Holat')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger')
                            ->size(IconSize::Large),
                    ])
                    ->columns(3),

                Section::make('Tizim ma\'lumotlari')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Yaratilgan')
                            ->dateTime('d.m.Y H:i')
                            ->placeholder('-'),

                        TextEntry::make('updated_at')
                            ->label('O\'zgartirilgan')
                            ->dateTime('d.m.Y H:i')
                            ->placeholder('-'),
                    ])
                    ->columns(2)
                    ->collapsed(),
            ]);
    }
}
