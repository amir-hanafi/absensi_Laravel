<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Matapel;

class GuruMatapelSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();
        $matapels = Matapel::all();

        if ($gurus->isEmpty() || $matapels->isEmpty()) {
            return;
        }

        foreach ($gurus as $guru) {

            // setiap guru dapat 2 mapel random
            $randomMatapel = $matapels->random(2);

            foreach ($randomMatapel as $mapel) {
                $guru->matapel()->attach($mapel->id);
            }
        }
    }
}