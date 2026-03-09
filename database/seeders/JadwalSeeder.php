<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Guru;
use App\Models\Matapel;
use App\Models\Kelas;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();
        $matapels = Matapel::all();
        $kelasList = Kelas::all();

        if ($gurus->isEmpty() || $matapels->isEmpty() || $kelasList->isEmpty()) {
            return;
        }

        $hariList = [
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat"
        ];

        $jamList = [1,2,3,4,5];

        foreach ($kelasList as $kelas) {

            foreach ($hariList as $hari) {

                foreach ($jamList as $jamKe) {

                    Jadwal::create([
                        'hari' => $hari,
                        'jam_ke' => $jamKe,
                        'guru_id' => $gurus->random()->id,
                        'matapel_id' => $matapels->random()->id,
                        'kelas_id' => $kelas->id,
                    ]);

                }

            }

        }
    }
}