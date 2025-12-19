<?php

namespace App\Filament\Resources\IncomingStockTransactionResource\Pages;

use App\Filament\Resources\IncomingStockTransactionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStockTransactions extends ListRecords
{
    protected static string $resource = IncomingStockTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('Kirim yaratish')),
        ];
    }
}
