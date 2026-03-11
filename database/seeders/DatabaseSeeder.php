<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Semua seeding dikontrol dari sini
        $this->call([
            UserSeeder::class,
            GuruSeeder::class,
            KelasSeeder::class,
            SiswaSeeder::class,
            MatapelSeeder::class,
            GuruMatapelSeeder::class,
            JadwalSekolahSeeder::class,
            JadwalSeeder::class,
            PlaceSeeder::class,
            // AssessmentCategorySeeder::class,
        ]);
    }
}
