<?php

namespace Database\Seeders;

use App\Models\WarehouseLocation;
use Illuminate\Database\Seeder;

class WarehouseLocationSeeder extends Seeder
{
    public function run(): void
    {
        $sections = ['A', 'B', 'C'];
        $racks = range(1, 5); // 1 dan 5 gacha tokchalar
        $shelves = range(1, 4); // 1 dan 4 gacha polkalar

        foreach ($sections as $section) {
            foreach ($racks as $rack) {
                foreach ($shelves as $shelf) {
                    $rackCode = str_pad($rack, 2, '0', STR_PAD_LEFT);
                    $shelfCode = str_pad($shelf, 2, '0', STR_PAD_LEFT);
                    $code = "{$section}-{$rackCode}-{$shelfCode}";

                    WarehouseLocation::create([
                        'code' => $code,
                        'section' => $section,
                        'rack' => $rackCode,
                        'shelf' => $shelfCode,
                        'notes' => "Seksiya {$section}, Tokcha {$rack}, Polka {$shelf}",
                        'status' => true,
                    ]);
                }
            }
        }
    }
}
