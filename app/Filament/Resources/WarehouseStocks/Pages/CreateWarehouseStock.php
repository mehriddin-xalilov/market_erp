<?php

namespace App\Filament\Resources\WarehouseStocks\Pages;

use App\Filament\Resources\WarehouseStocks\WarehouseStockResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWarehouseStock extends CreateRecord
{
    protected static string $resource = WarehouseStockResource::class;

    public function getTitle(): string
    {
        return __('Ombor zaxirasi');
    }
}
