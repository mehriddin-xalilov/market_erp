<?php

namespace App\Filament\Resources\IncomingStockTransactionResource\Pages;

use App\Filament\Resources\IncomingStockTransactionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStockTransaction extends EditRecord
{
    protected static string $resource = IncomingStockTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
