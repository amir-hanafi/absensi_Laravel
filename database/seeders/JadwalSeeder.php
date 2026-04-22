<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\JadwalSekolah;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Matapel;

class JadwalSeeder extends Seeder
{
    public function run(): void
    {
        $jadwalSekolahList = JadwalSekolah::all();
        $kelasList = Kelas::all();
        $gurus = Guru::all();
        $matapels = Matapel::all();

        if (
            $jadwalSekolahList->isEmpty() ||
            $kelasList->isEmpty() ||
            $gurus->isEmpty() ||
            $matapels->isEmpty()
        ) {
            return;
        }

        foreach ($kelasList as $kelas) {

            foreach ($jadwalSekolahList as $jadwalSekolah) {

                // 🔥 ambil guru random
                $guru = $gurus->random();

                // 🔥 ambil mapel random
                $mapel = $matapels->random();

                Jadwal::create([
                    'jadwal_sekolah_id' => $jadwalSekolah->id,
                    'kelas_id' => $kelas->id,
                    'guru_id' => $guru->id,
                    'matapel_id' => $mapel->id,
                ]);
            }
        }
    }
}
