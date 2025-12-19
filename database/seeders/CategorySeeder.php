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
                'name' => 'Elektronika',
                'code' => 'ELEC',
                'description' => 'Barcha turdagi elektronika mahsulotlari',
                'status' => true,
                'children' => [
                    ['name' => 'Smartfonlar', 'code' => 'SMART', 'description' => 'Eng so\'nggi smartfonlar'],
                    ['name' => 'Noutbuklar', 'code' => 'LAPTOP', 'description' => 'Ish va o\'yin uchun noutbuklar'],
                    ['name' => 'Televizorlar', 'code' => 'TV', 'description' => 'Smart TV va aksessuarlar'],
                ],
            ],
            [
                'name' => 'Maishiy texnika',
                'code' => 'APPL',
                'description' => 'Uy uchun maishiy texnika',
                'status' => true,
                'children' => [
                    ['name' => 'Muzlatgichlar', 'code' => 'FRIDGE', 'description' => 'Katta va kichik muzlatgichlar'],
                    ['name' => 'Kir yuvish mashinalari', 'code' => 'WASH', 'description' => 'Avtomat va yarim avtomat'],
                ],
            ],
            [
                'name' => 'Oziq-ovqat',
                'code' => 'FOOD',
                'description' => 'Kundalik oziq-ovqat mahsulotlari',
                'status' => true,
                'children' => [
                    ['name' => 'Ichimliklar', 'code' => 'DRINK', 'description' => 'Gazli va gazsiz ichimliklar'],
                    ['name' => 'Shirinliklar', 'code' => 'SWEET', 'description' => 'Shokolad va pechenyalar'],
                ],
            ],
            [
                'name' => 'Kiyim-kechak',
                'code' => 'CLOTH',
                'description' => 'Erkaklar va ayollar kiyimlari',
                'status' => true,
                'children' => [
                    ['name' => 'Erkaklar kiyimi', 'code' => 'MEN', 'description' => 'Shimlar, ko\'ylaklar'],
                    ['name' => 'Ayollar kiyimi', 'code' => 'WOMEN', 'description' => 'Ko\'ylaklar, yubkalar'],
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
