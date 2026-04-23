<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @file
 * @brief Seeder utama untuk project Laravel
 *
 * Seeder ini memanggil semua seeder lain yang diperlukan untuk
 * mengisi data awal database.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * @brief Jalankan seeding database
     *
     * Semua seeding dikontrol dari sini melalui pemanggilan
     * seeder-seeder individual.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,          /**< Seeder untuk tabel users */
            GuruSeeder::class,          /**< Seeder untuk tabel guru */
            KelasSeeder::class,         /**< Seeder untuk tabel kelas */
            SiswaSeeder::class,         /**< Seeder untuk tabel siswa */
            MatapelSeeder::class,       /**< Seeder untuk tabel matapel */
            GuruMatapelSeeder::class,   /**< Seeder untuk tabel pivot guru_matapel */
            JadwalSekolahSeeder::class, /**< Seeder untuk tabel jadwal_sekolah */
            JadwalSeeder::class,      /**< Seeder untuk tabel jadwal (di-comment) */
            PlaceSeeder::class,         /**< Seeder untuk tabel places */
            PointRuleSeeder::class,        
            FlexibilityItemSeeder::class,       
            CategorySeeder::class,
            // AssessmentCategorySeeder::class, /**< Seeder untuk kategori penilaian (di-comment) */
        ]);
    }
}