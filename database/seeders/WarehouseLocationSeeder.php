<?php

namespace Database\Seeders;

use App\Models\WarehouseLocation;
use Illuminate\Database\Seeder;

class WarehouseLocationSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            [
                'name' => 'Asosiy Ombor',
                'address' => 'Toshkent sh., Chilonzor tumani',
                'status' => true,
            ],
            [
                'name' => 'Filial 1',
                'address' => 'Toshkent sh., Yunusobod tumani',
                'status' => true,
            ],
            [
                'name' => 'Filial 2',
                'address' => 'Toshkent sh., Mirzo Ulug\'bek tumani',
                'status' => true,
            ],
        ];

        foreach ($locations as $location) {
            WarehouseLocation::create($location);
        }
    }
}
