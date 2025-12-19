<?php

namespace App\Filament\Resources\IncomingStockTransactionResource\Pages;

use App\Filament\Resources\IncomingStockTransactionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockTransaction extends ViewRecord
{
    protected static string $resource = IncomingStockTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
