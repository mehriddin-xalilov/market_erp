<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;


class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Kategoriya ma\'lumotlari')
                    ->schema([
                        TextEntry::make('code')
                            ->label('Kod')
                            ->copyable(),

                        TextEntry::make('name')
                            ->label('Nomi'),

                        TextEntry::make('parent.name')
                            ->label('Ota kategoriya')
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label('Tavsif')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        \Filament\Infolists\Components\ImageEntry::make('photo')
                            ->label('Rasm')
                            ->placeholder('-'),

                        \Filament\Infolists\Components\IconEntry::make('status')
                            ->label('Holat')
                            ->boolean()
                            ->trueIcon('heroicon-o-check-circle')
                            ->falseIcon('heroicon-o-x-circle')
                            ->trueColor('success')
                            ->falseColor('danger'),

                        TextEntry::make('created_at')
                            ->label('Yaratilgan sana')
                            ->dateTime('d.m.Y H:i'),

                        TextEntry::make('updated_at')
                            ->label('Yangilangan sana')
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
