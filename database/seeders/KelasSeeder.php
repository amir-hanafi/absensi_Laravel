<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $gurus = Guru::all();

        if ($gurus->isEmpty()) {
            return;
        }

        foreach ($gurus as $index => $guru) {

            // Kelas 10
            Kelas::create([
                'nama_kelas'    => 'X-IPA-' . ($index + 1),
                'tingkat_kelas' => 10,
                'guru_id'       => $guru->id,
            ]);

            Kelas::create([
                'nama_kelas'    => 'X-IPS-' . ($index + 1),
                'tingkat_kelas' => 10,
                'guru_id'       => $guru->id,
            ]);

            // Kelas 11
            Kelas::create([
                'nama_kelas'    => 'XI-IPA-' . ($index + 1),
                'tingkat_kelas' => 11,
                'guru_id'       => $guru->id,
            ]);

            Kelas::create([
                'nama_kelas'    => 'XI-IPS-' . ($index + 1),
                'tingkat_kelas' => 11,
                'guru_id'       => $guru->id,
            ]);

            // Kelas 12
            Kelas::create([
                'nama_kelas'    => 'XII-IPA-' . ($index + 1),
                'tingkat_kelas' => 12,
                'guru_id'       => $guru->id,
            ]);

            Kelas::create([
                'nama_kelas'    => 'XII-IPS-' . ($index + 1),
                'tingkat_kelas' => 12,
                'guru_id'       => $guru->id,
            ]);
        }
    }
}
