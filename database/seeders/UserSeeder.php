<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Kelas;

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

        // =====================
        // GURU
        // =====================
        $guruUser = User::create([
            'username' => 'guru01',
            'password' => Hash::make('guru123'),
            'role'     => 'guru',
        ]);

        $guru = Guru::create([
            'kode_guru' => 'GR-001',
            'nama'      => 'Guru Demo',
            'no_hp'     => '08123456789',
            'user_id'   => $guruUser->id,
        ]);

        // =====================
        // KELAS
        // =====================
        $kelas = Kelas::create([
            'nama_kelas' => 'X-IPA-1',
            'guru_id'    => $guru->id,
        ]);

        // =====================
        // SISWA
        // =====================
        $siswaUser = User::create([
            'username' => 'siswa01',
            'password' => Hash::make('siswa123'),
            'role'     => 'siswa',
        ]);

        Siswa::create([
            'nis'      => '12345678',
            'nama'     => 'Siswa Demo',
            'kelas_id' => $kelas->id,
            'user_id'  => $siswaUser->id,
        ]);
    }
}
