<?php

namespace App\Filament\Resources\OutgoingStockTransactionResource\Pages;

use App\Filament\Resources\OutgoingStockTransactionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStockTransaction extends CreateRecord
{
    protected static string $resource = OutgoingStockTransactionResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return __('Chiqim');
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        $items = $data['items'] ?? [];
        unset($data['items']);

        $record = null;

        \Illuminate\Support\Facades\DB::transaction(function () use ($data, $items, &$record) {
            foreach ($items as $item) {
                $transactionData = array_merge($data, $item);
                $record = static::getModel()::create($transactionData);
            }
        });

        return $record;
    }
}
