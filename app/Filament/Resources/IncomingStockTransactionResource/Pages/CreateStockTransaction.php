<?php

namespace App\Filament\Resources\IncomingStockTransactionResource\Pages;

use App\Filament\Resources\IncomingStockTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStockTransaction extends CreateRecord
{
    protected static string $resource = IncomingStockTransactionResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('Kirim');
    }
}
