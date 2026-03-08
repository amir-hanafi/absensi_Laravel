<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    public function run(): void
    {
        Place::create([
            'name' => 'Sekolah kampus 1',
            'latitude' => -6.825291182355525,
            'longitude' => 107.1370873337728,
            'allowed_radius' => 100
        ]);

        Place::create([
            'name' => 'rumah',
            'latitude' => -6.831903817044308,
            'longitude' => 107.17791679703814,
            'allowed_radius' => 100
        ]);
    }
}
