<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            'Smartfonlar' => [
                ['name' => 'iPhone 15 Pro Max', 'sku' => 'IP15PM-256', 'price' => 18000000, 'cost_price' => 16000000, 'unit' => 'dona', 'description' => 'Apple iPhone 15 Pro Max 256GB'],
                ['name' => 'Samsung Galaxy S24 Ultra', 'sku' => 'S24U-512', 'price' => 17000000, 'cost_price' => 15000000, 'unit' => 'dona', 'description' => 'Samsung Galaxy S24 Ultra 512GB'],
                ['name' => 'Xiaomi 14 Ultra', 'sku' => 'MI14U-512', 'price' => 13000000, 'cost_price' => 11000000, 'unit' => 'dona', 'description' => 'Xiaomi 14 Ultra 512GB'],
            ],
            'Noutbuklar' => [
                ['name' => 'MacBook Pro 14 M3', 'sku' => 'MBP14-M3', 'price' => 24000000, 'cost_price' => 21000000, 'unit' => 'dona', 'description' => 'Apple MacBook Pro 14 M3 Chip'],
                ['name' => 'Dell XPS 15', 'sku' => 'DELL-XPS15', 'price' => 22000000, 'cost_price' => 19000000, 'unit' => 'dona', 'description' => 'Dell XPS 15 OLED Display'],
            ],
            'Televizorlar' => [
                ['name' => 'LG OLED C3 55"', 'sku' => 'LG-C3-55', 'price' => 19000000, 'cost_price' => 16000000, 'unit' => 'dona', 'description' => 'LG OLED evo C3 55 inch 4K Smart TV'],
                ['name' => 'Sony Bravia XR 65"', 'sku' => 'SONY-XR-65', 'price' => 21000000, 'cost_price' => 18000000, 'unit' => 'dona', 'description' => 'Sony Bravia XR A80L 65 inch OLED'],
            ],
            'Muzlatgichlar' => [
                ['name' => 'Samsung Bespoke', 'sku' => 'SAM-BESPOKE', 'price' => 15000000, 'cost_price' => 12000000, 'unit' => 'dona', 'description' => 'Samsung Bespoke 4-Door Flex Refrigerator'],
                ['name' => 'LG InstaView', 'sku' => 'LG-INSTA', 'price' => 18000000, 'cost_price' => 15000000, 'unit' => 'dona', 'description' => 'LG InstaView Door-in-Door Refrigerator'],
            ],
            'Ichimliklar' => [
                ['name' => 'Coca-Cola 1.5L', 'sku' => 'COKE-1.5', 'price' => 12000, 'cost_price' => 8000, 'unit' => 'dona', 'description' => 'Coca-Cola Classic 1.5L'],
                ['name' => 'Pepsi 1L', 'sku' => 'PEPSI-1', 'price' => 10000, 'cost_price' => 7000, 'unit' => 'dona', 'description' => 'Pepsi Cola 1L'],
                ['name' => 'Fanta 1.5L', 'sku' => 'FANTA-1.5', 'price' => 12000, 'cost_price' => 8000, 'unit' => 'dona', 'description' => 'Fanta Orange 1.5L'],
            ],
            'Shirinliklar' => [
                ['name' => 'Snickers Super', 'sku' => 'SNICKERS-S', 'price' => 8000, 'cost_price' => 5000, 'unit' => 'dona', 'description' => 'Snickers Super Chocolate Bar'],
                ['name' => 'KitKat 4 Finger', 'sku' => 'KITKAT-4', 'price' => 7000, 'cost_price' => 4000, 'unit' => 'dona', 'description' => 'Nestle KitKat 4 Finger'],
            ],
        ];

        foreach ($products as $categoryName => $items) {
            $category = Category::where('name', $categoryName)->first();

            if ($category) {
                foreach ($items as $item) {
                    Product::create([
                        'category_id' => $category->id,
                        'name' => $item['name'],
                        'sku' => $item['sku'],
                        'description' => $item['description'],
                        'price' => $item['price'],
                        'cost_price' => $item['cost_price'],
                        'unit' => $item['unit'],
                        'current_stock' => 0, // Boshlang'ich zaxira 0, WarehouseStock orqali to'ldiriladi
                        'reorder_level' => 10,
                        'status' => true,
                    ]);
                }
            }
        }
    }
}
