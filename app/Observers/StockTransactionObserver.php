<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\WarehouseStock;

class StockTransactionObserver
{
    /**
     * Handle the StockTransaction "created" event.
     */
    public function created(StockTransaction $stockTransaction): void
    {
        // Get the quantity and type
        $quantity = $stockTransaction->quantity;
        $type = $stockTransaction->type;
        $productId = $stockTransaction->product_id;
        $warehouseLocationId = $stockTransaction->warehouse_location_id;

        // Determine if we're adding or subtracting stock
        // Type 1 = Incoming (add stock), Type 2 = Outgoing (subtract stock)
        $quantityChange = $type === 1 ? $quantity : -$quantity;

        // Update Product current_stock
        $product = Product::find($productId);
        if ($product) {
            $product->increment('current_stock', $quantityChange);
        }

        // Update or Create WarehouseStock
        $warehouseStock = WarehouseStock::where('product_id', $productId)
            ->where('warehouse_location_id', $warehouseLocationId)
            ->first();

        if ($warehouseStock) {
            // Update existing warehouse stock
            $warehouseStock->increment('quantity', $quantityChange);
            $warehouseStock->update(['last_updated_at' => now()]);
        } else {
            // Create new warehouse stock record (only for incoming transactions)
            if ($type === 1) {
                WarehouseStock::create([
                    'product_id' => $productId,
                    'warehouse_location_id' => $warehouseLocationId,
                    'quantity' => $quantity,
                    'last_updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Handle the StockTransaction "updated" event.
     */
    public function updated(StockTransaction $stockTransaction): void
    {
        //
    }

    /**
     * Handle the StockTransaction "deleted" event.
     */
    public function deleted(StockTransaction $stockTransaction): void
    {
        //
    }

    /**
     * Handle the StockTransaction "restored" event.
     */
    public function restored(StockTransaction $stockTransaction): void
    {
        //
    }

    /**
     * Handle the StockTransaction "force deleted" event.
     */
    public function forceDeleted(StockTransaction $stockTransaction): void
    {
        //
    }
}
