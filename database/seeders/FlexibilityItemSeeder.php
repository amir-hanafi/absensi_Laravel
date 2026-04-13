<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FlexibilityItem;

class FlexibilityItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FlexibilityItem::truncate();

        FlexibilityItem::insert([
            [
                'item_name' => 'Bebas Telat 15 Menit',
                'point_cost' => 10,
                'max_late_minutes' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
