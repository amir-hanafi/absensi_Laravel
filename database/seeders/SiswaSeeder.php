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
        $kelasList  = Kelas::all();

        if ($siswaUsers->isEmpty() || $kelasList->isEmpty()) {
            return;
        }

        foreach ($siswaUsers as $index => $user) {

            // Pilih kelas secara bergilir
            $kelas = $kelasList[$index % $kelasList->count()];

            Siswa::create([
                'nis'      => 'NIS' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'nama'     => 'Siswa ' . ($index + 1),
                'kelas_id' => $kelas->id,
                'user_id'  => $user->id,
            ]);
        }
    }
}