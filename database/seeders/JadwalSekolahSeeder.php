<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalSekolah;

class JadwalSekolahSeeder extends Seeder
{
    public function run(): void
    {
        $hariList = [
            "Senin",
            "Selasa",
            "Rabu",
            "Kamis",
            "Jumat"
        ];

        $jamList = [
            ["01:00:00", "07:45:00"],
            ["07:45:00", "08:30:00"],
            ["08:30:00", "09:15:00"],
            ["09:30:00", "10:15:00"],
            ["10:15:00", "11:00:00"],
            ["11:00:00", "23:00:00"],
        ];

        foreach ($hariList as $hari) {

            foreach ($jamList as $index => $jam) {

                JadwalSekolah::create([
                    'hari' => $hari,
                    'jam_ke' => $index + 1,
                    'jam_mulai' => $jam[0],
                    'jam_selesai' => $jam[1],
                ]);

            }

        }
    }
}