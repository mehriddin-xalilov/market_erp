<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asosiy ma\'lumotlar')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('code')
                            ->label('Kod')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->alphaDash(),

                        \Filament\Forms\Components\TextInput::make('name')
                            ->label('Nomi')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        \Filament\Forms\Components\Select::make('parent_id')
                            ->label('Ota kategoriya')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        \Filament\Forms\Components\Textarea::make('description')
                            ->label('Tavsif')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Rasm va holat')
                    ->schema([
                        \Filament\Forms\Components\FileUpload::make('photo')
                            ->label('Rasm')
                            ->image()
                            ->imageEditor()
                            ->directory('categories')
                            ->nullable(),

                        \Filament\Forms\Components\Toggle::make('status')
                            ->label('Holat')
                            ->default(true)
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Faol / Nofaol'),
                    ])
                    ->columns(2),
            ]);
    }
}
