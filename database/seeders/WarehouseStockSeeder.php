<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\WarehouseLocation;
use App\Models\WarehouseStock;
use Illuminate\Database\Seeder;

class WarehouseStockSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $locations = WarehouseLocation::all();

        if ($products->isEmpty() || $locations->isEmpty()) {
            return;
        }

        foreach ($products as $product) {
            // Har bir mahsulotni 1-3 ta joyga qo'yamiz
            $randomLocations = $locations->random(rand(1, 3));
            $totalStock = 0;

            foreach ($randomLocations as $location) {
                $quantity = rand(10, 100);
                $totalStock += $quantity;

                WarehouseStock::create([
                    'product_id' => $product->id,
                    'warehouse_location_id' => $location->id,
                    'quantity' => $quantity,
                    'last_updated_at' => now(),
                ]);
            }

            // Mahsulotning umumiy zaxirasini yangilash
            $product->update(['current_stock' => $totalStock]);
        }
    }
}
