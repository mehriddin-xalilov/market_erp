<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Foydalanuvchi ma\'lumotlari')
                    ->schema([
                        \Filament\Infolists\Components\TextEntry::make('name')
                            ->label('Ism'),

                        \Filament\Infolists\Components\TextEntry::make('email')
                            ->label('Email')
                            ->copyable(),

                        \Filament\Infolists\Components\TextEntry::make('roles.name')
                            ->label('Rollar')
                            ->badge()
                            ->separator(','),

                        \Filament\Infolists\Components\TextEntry::make('created_at')
                            ->label('Yaratilgan sana')
                            ->dateTime('d.m.Y H:i'),

                        \Filament\Infolists\Components\TextEntry::make('updated_at')
                            ->label('Yangilangan sana')
                            ->dateTime('d.m.Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}
