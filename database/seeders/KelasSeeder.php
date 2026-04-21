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

            
            Kelas::create([
                'nama_kelas' => 'X-IPA-' . ($index + 1),
                'guru_id'    => $guru->id,
            ]);

            Kelas::create([
                'nama_kelas' => 'X-IPS-' . ($index + 1),
                'guru_id'    => $guru->id,
            ]);
        }
    }
}