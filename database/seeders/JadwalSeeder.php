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

        $jamList = [
            ["07:00:00", "08:30:00"],
            ["08:30:00", "10:00:00"],
            ["10:15:00", "11:45:00"],
            ["13:00:00", "14:30:00"],
            ["14:30:00", "20:00:00"],
        ];

        foreach ($gurus as $guru) {

            foreach ($matapels->random(2) as $mapel) {

                $kelas = $kelasList->random();
                $hari = collect($hariList)->random();
                $jam = collect($jamList)->random();

                Jadwal::create([
                    'tanggal'    => Carbon::today(),
                    'hari'       => $hari,
                    'jam_mulai'  => $jam[0],
                    'jam_selesai' => $jam[1],
                    'guru_id'    => $guru->id,
                    'matapel_id' => $mapel->id,
                    'kelas_id'   => $kelas->id,
                ]);
            }
        }
    }
}
