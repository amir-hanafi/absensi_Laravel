<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // =====================
        // ADMIN
        // =====================
        $admin = User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        $guruUser = User::create([
            'username' => 'guru01',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
        ]);
        $guruUser = User::create([
            'username' => 'guru02',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
        ]);
        $guruUser = User::create([
            'username' => 'guru03',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
        ]);

        $siswaUser = User::create([
            'username' => 'siswa01',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);

    }
}
