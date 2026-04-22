<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaUsers = User::where('role', 'siswa')->get();

        if ($siswaUsers->isEmpty()) {
            return;
        }

        $tahunSekarang = date('Y');
        $nisCounter = 1;

        foreach ($siswaUsers as $index => $user) {

            // 🔥 semua mulai dari kelas 10
            $tingkat = 10;

            // 🔥 variasi tahun masuk (biar ada yang kelas 10,11,12)
            $tahunMasuk = $tahunSekarang - ($index % 3);

            // 🔥 kelas HARUS tingkat 10
            $kelas = Kelas::where('tingkat_kelas', 10)->inRandomOrder()->first();

            // kalau tidak ada kelas, skip
            if (!$kelas) continue;

            Siswa::create([
                'nis' => 'NIS' . str_pad($nisCounter++, 4, '0', STR_PAD_LEFT),
                'nama' => 'Siswa ' . ($index + 1),
                'tahun_masuk' => $tahunMasuk,

                'kelas_id' => $kelas->id,
                'user_id' => $user->id,
            ]);
        }
    }
}
