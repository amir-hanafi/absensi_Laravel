<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Guru;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruUsers = User::where('role', 'guru')->get();

        if ($guruUsers->isEmpty()) {
            return;
        }

        $no = 1;

        foreach ($guruUsers as $user) {

            Guru::create([
                'kode_guru' => 'GR-' . str_pad($no++, 3, '0', STR_PAD_LEFT),
                'nama'      => 'Arhan',
                'no_hp'     => '08123456780',
                'user_id'   => $user->id,
            ]);

            Guru::create([
                'kode_guru' => 'GR-' . str_pad($no++, 3, '0', STR_PAD_LEFT),
                'nama'      => 'Sulaiman',
                'no_hp'     => '08123456781',
                'user_id'   => $user->id,
            ]);

            Guru::create([
                'kode_guru' => 'GR-' . str_pad($no++, 3, '0', STR_PAD_LEFT),
                'nama'      => 'Fikri',
                'no_hp'     => '08123456782',
                'user_id'   => $user->id,
            ]);
        }
    }
}