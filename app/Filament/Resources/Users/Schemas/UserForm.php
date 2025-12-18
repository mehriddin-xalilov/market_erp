<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asosiy ma\'lumotlar')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Ism')
                            ->required()
                            ->maxLength(255),

                        \Filament\Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Xavfsizlik')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('password')
                            ->label('Parol')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->minLength(8)
                            ->dehydrated(fn($state) => filled($state))
                            ->revealable(),

                        \Filament\Forms\Components\TextInput::make('password_confirmation')
                            ->label('Parolni tasdiqlash')
                            ->password()
                            ->same('password')
                            ->dehydrated(false)
                            ->revealable(),
                    ])
                    ->columns(2),

                Section::make('Ruxsatlar')
                    ->schema([
                        \Filament\Forms\Components\Select::make('roles')
                            ->label('Rollar')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable(),
                    ]),
            ]);
    }
}
