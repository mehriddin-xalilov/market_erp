<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Models\User;
use App\Models\WarehouseLocation;
use Illuminate\Database\Seeder;

class StockTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $locations = WarehouseLocation::all();
        $user = User::first(); // Admin user

        if ($products->isEmpty() || $locations->isEmpty() || !$user) {
            return;
        }

        foreach ($products as $product) {
            // Har bir mahsulot uchun 5-10 ta tranzaksiya
            $transactionsCount = rand(5, 10);

            for ($i = 0; $i < $transactionsCount; $i++) {
                $type = rand(1, 2); // 1: Kirim, 2: Chiqim
                $quantity = rand(1, 20);
                $location = $locations->random();
                $unitPrice = $product->price;
                $totalPrice = $unitPrice * $quantity;

                StockTransaction::create([
                    'product_id' => $product->id,
                    'warehouse_location_id' => $location->id,
                    'user_id' => $user->id,
                    'type' => $type,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_price' => $totalPrice,
                    'reference_no' => 'TRX-' . strtoupper(uniqid()),
                    'notes' => $type == 1 ? 'Yangi partiya qabul qilindi' : 'Mijozga sotildi',
                    'created_at' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }
}
