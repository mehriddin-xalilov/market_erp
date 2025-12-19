<?php

namespace App\Filament\Resources\OutgoingStockTransactionResource\Pages;

use App\Filament\Resources\OutgoingStockTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockTransactions extends ListRecords
{
    protected static string $resource = OutgoingStockTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Chiqim yaratish')),
        ];
    }
}
