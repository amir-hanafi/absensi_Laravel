<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matapel;

class MatapelSeeder extends Seeder
{
    public function run(): void
    {
        Matapel::create(['mata_pelajaran' => 'Matematika']);
        Matapel::create(['mata_pelajaran' => 'Fisika']);
        Matapel::create(['mata_pelajaran' => 'Bahasa Indonesia']);
        Matapel::create(['mata_pelajaran' => 'Kimia']);
    }
}