<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sement va Gips',
                'code' => 'CEMENT',
                'description' => 'Qurilish uchun sement va gips mahsulotlari',
                'status' => true,
                'children' => [
                    ['name' => 'Portlandsement', 'code' => 'PC', 'description' => 'M400, M500 portlandsement'],
                    ['name' => 'Gips', 'code' => 'GIPS', 'description' => 'Ichki ishlar uchun gips'],
                    ['name' => 'Quruq aralashmalar', 'code' => 'DRY', 'description' => 'Tayyor quruq aralashmalar'],
                ],
            ],
            [
                'name' => 'G\'isht va Bloklar',
                'code' => 'BRICK',
                'description' => 'Turli xil g\'isht va qurilish bloklari',
                'status' => true,
                'children' => [
                    ['name' => 'Qizil g\'isht', 'code' => 'REDBRICK', 'description' => 'Klassik qizil g\'isht'],
                    ['name' => 'Silikat g\'isht', 'code' => 'SILICATE', 'description' => 'Oq silikat g\'isht'],
                    ['name' => 'Penoblok', 'code' => 'FOAM', 'description' => 'Yengil penobloklar'],
                ],
            ],
            [
                'name' => 'Bo\'yoq va Lak',
                'code' => 'PAINT',
                'description' => 'Ichki va tashqi ishlar uchun bo\'yoqlar',
                'status' => true,
                'children' => [
                    ['name' => 'Ichki bo\'yoq', 'code' => 'INTERIOR', 'description' => 'Ichki devorlar uchun'],
                    ['name' => 'Tashqi bo\'yoq', 'code' => 'EXTERIOR', 'description' => 'Fasad uchun'],
                    ['name' => 'Lak va emali', 'code' => 'LACQUER', 'description' => 'Yog\'och va metall uchun'],
                ],
            ],
            [
                'name' => 'Elektr jihozlari',
                'code' => 'ELECTRIC',
                'description' => 'Elektr o\'tkazgichlar va jihozlar',
                'status' => true,
                'children' => [
                    ['name' => 'Simlar va kabellar', 'code' => 'WIRE', 'description' => 'Elektr simlari'],
                    ['name' => 'Rozetkalar va kalitlar', 'code' => 'SOCKET', 'description' => 'Elektr aksessuarlari'],
                ],
            ],
            [
                'name' => 'Santexnika',
                'code' => 'PLUMB',
                'description' => 'Suv va kanalizatsiya uchun mahsulotlar',
                'status' => true,
                'children' => [
                    ['name' => 'Quvurlar', 'code' => 'PIPE', 'description' => 'Plastik va metall quvurlar'],
                    ['name' => 'Armatura', 'code' => 'FITT', 'description' => 'Quvur fitinglari'],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $children = $categoryData['children'] ?? [];
            unset($categoryData['children']);

            $parentCategory = Category::create($categoryData);

            foreach ($children as $childData) {
                $childData['parent_id'] = $parentCategory->id;
                $childData['status'] = true;
                Category::create($childData);
            }
        }
    }
}
