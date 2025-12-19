<?php

namespace App\Filament\Resources\OutgoingStockTransactionResource\Pages;

use App\Filament\Resources\OutgoingStockTransactionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStockTransaction extends ViewRecord
{
    protected static string $resource = OutgoingStockTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
