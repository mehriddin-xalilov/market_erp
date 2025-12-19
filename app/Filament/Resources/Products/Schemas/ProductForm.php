<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Asosiy ma\'lumotlar')
                    ->schema([
                        TextInput::make('name')
                            ->label('Mahsulot nomi')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('sku')
                            ->label('SKU/Artikul')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('category_id')
                            ->label('Kategoriya')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(1),

                        Textarea::make('description')
                            ->label('Tavsif')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Narx ma\'lumotlari')
                    ->schema([


                        TextInput::make('price')
                            ->label('Sotuv narxi')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->suffix('so\'m')
                            ->columnSpan(1),

                        Select::make('unit')
                            ->label('O\'lchov birligi')
                            ->options([
                                'dona' => 'Dona',
                                'kg' => 'Kilogram (kg)',
                                'litr' => 'Litr',
                                'metr' => 'Metr',
                                'm2' => 'Kvadrat metr (m²)',
                                'm3' => 'Kub metr (m³)',
                                'komplekt' => 'Komplekt',
                                'quti' => 'Quti',
                                'paket' => 'Paket',
                            ])
                            ->default('dona')
                            ->required()
                            ->searchable()
                            ->columnSpan(1),
                    ])
                    ->columns(3),

                Section::make('Ombor ma\'lumotlari')
                    ->schema([
                        TextInput::make('current_stock')
                            ->label('Joriy zaxira')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->columnSpan(1),

                        TextInput::make('reorder_level')
                            ->label('Minimal zaxira')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->default(10)
                            ->helperText('Zaxira bu miqdordan kam bo\'lganda ogohlantirish beriladi')
                            ->columnSpan(1),

                        Toggle::make('status')
                            ->label('Holat')
                            ->default(true)
                            ->inline(false)
                            ->onColor('success')
                            ->offColor('danger')
                            ->helperText('Faol / Nofaol')
                            ->columnSpan(1),
                    ])
                    ->columns(3),
            ]);
    }
}
