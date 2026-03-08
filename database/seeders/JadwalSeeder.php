<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\Matapel;
use App\Models\Kelas;
use Carbon\Carbon;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();
        $matapels = Matapel::all();

        if ($gurus->isEmpty() || $matapels->isEmpty()) {
            return;
        }

        $date = Carbon::today();

        foreach ($gurus as $guru) {

            foreach ($matapels->random(2) as $mapel) {

                Jadwal::create([
                    'tanggal'    => $date,
                    'guru_id'    => $guru->id,
                    'matapel_id' => $mapel->id,
                ]);

                $date = $date->addDay();
            }
        }
    }
}