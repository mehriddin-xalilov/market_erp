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
            'Portlandsement' => [
                ['name' => 'Sement M400 50kg', 'sku' => 'CEM-M400-50', 'price' => 65000, 'cost_price' => 55000, 'unit' => 'qop', 'description' => 'Portlandsement M400 50kg qop'],
                ['name' => 'Sement M500 50kg', 'sku' => 'CEM-M500-50', 'price' => 75000, 'cost_price' => 65000, 'unit' => 'qop', 'description' => 'Portlandsement M500 50kg qop'],
            ],
            'Gips' => [
                ['name' => 'Gips Knauf 30kg', 'sku' => 'GIPS-KN-30', 'price' => 85000, 'cost_price' => 72000, 'unit' => 'qop', 'description' => 'Knauf gips 30kg'],
                ['name' => 'Gips Volma 25kg', 'sku' => 'GIPS-VL-25', 'price' => 70000, 'cost_price' => 60000, 'unit' => 'qop', 'description' => 'Volma gips 25kg'],
            ],
            'Quruq aralashmalar' => [
                ['name' => 'Shpaklevka 20kg', 'sku' => 'SHPAK-20', 'price' => 45000, 'cost_price' => 38000, 'unit' => 'qop', 'description' => 'Shpaklevka quruq aralashma 20kg'],
            ],
            'Qizil g\'isht' => [
                ['name' => 'G\'isht qizil M100', 'sku' => 'BRICK-R-M100', 'price' => 1200, 'cost_price' => 900, 'unit' => 'dona', 'description' => 'Qizil g\'isht M100 250x120x65mm'],
                ['name' => 'G\'isht qizil M150', 'sku' => 'BRICK-R-M150', 'price' => 1500, 'cost_price' => 1200, 'unit' => 'dona', 'description' => 'Qizil g\'isht M150 250x120x65mm'],
            ],
            'Silikat g\'isht' => [
                ['name' => 'G\'isht silikat M150', 'sku' => 'BRICK-S-M150', 'price' => 1800, 'cost_price' => 1500, 'unit' => 'dona', 'description' => 'Oq silikat g\'isht M150'],
            ],
            'Penoblok' => [
                ['name' => 'Penoblok 600x300x200', 'sku' => 'FOAM-600', 'price' => 12000, 'cost_price' => 10000, 'unit' => 'dona', 'description' => 'Penoblok 600x300x200mm'],
            ],
            'Ichki bo\'yoq' => [
                ['name' => 'Bo\'yoq Dulux ichki 10L', 'sku' => 'PAINT-DX-10', 'price' => 450000, 'cost_price' => 380000, 'unit' => 'chelak', 'description' => 'Dulux ichki bo\'yoq 10L'],
                ['name' => 'Bo\'yoq Tikkurila 9L', 'sku' => 'PAINT-TK-9', 'price' => 520000, 'cost_price' => 440000, 'unit' => 'chelak', 'description' => 'Tikkurila ichki bo\'yoq 9L'],
            ],
            'Tashqi bo\'yoq' => [
                ['name' => 'Fasad bo\'yoqi 15L', 'sku' => 'PAINT-FS-15', 'price' => 380000, 'cost_price' => 320000, 'unit' => 'chelak', 'description' => 'Fasad uchun bo\'yoq 15L'],
            ],
            'Simlar va kabellar' => [
                ['name' => 'Kabel VVG 3x2.5', 'sku' => 'WIRE-VVG-3x2.5', 'price' => 8500, 'cost_price' => 7000, 'unit' => 'metr', 'description' => 'Kabel VVG 3x2.5mm'],
                ['name' => 'Kabel VVG 3x1.5', 'sku' => 'WIRE-VVG-3x1.5', 'price' => 6500, 'cost_price' => 5500, 'unit' => 'metr', 'description' => 'Kabel VVG 3x1.5mm'],
            ],
            'Rozetkalar va kalitlar' => [
                ['name' => 'Rozetka Legrand', 'sku' => 'SOCK-LG', 'price' => 25000, 'cost_price' => 20000, 'unit' => 'dona', 'description' => 'Legrand rozetka'],
                ['name' => 'Kalit 1-klapanli', 'sku' => 'SWITCH-1', 'price' => 18000, 'cost_price' => 15000, 'unit' => 'dona', 'description' => '1-klapanli kalit'],
            ],
            'Quvurlar' => [
                ['name' => 'Quvur PPR 20mm', 'sku' => 'PIPE-PPR-20', 'price' => 12000, 'cost_price' => 10000, 'unit' => 'metr', 'description' => 'PPR quvur 20mm'],
                ['name' => 'Quvur PPR 25mm', 'sku' => 'PIPE-PPR-25', 'price' => 15000, 'cost_price' => 12500, 'unit' => 'metr', 'description' => 'PPR quvur 25mm'],
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
