<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateMatapelTable
 * @brief Migration untuk membuat tabel matapel (mata pelajaran).
 *
 * Tabel ini digunakan untuk menyimpan daftar mata pelajaran
 * yang diajarkan di sekolah, seperti Matematika, Bahasa Indonesia,
 * Pemrograman, dan lain-lain.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `matapel` dengan struktur:
     * - id : Primary key
     * - mata_pelajaran : Nama mata pelajaran
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('matapel', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Nama mata pelajaran
            /// Contoh: Matematika, Bahasa Inggris, Pemrograman Web
            $table->string('mata_pelajaran');

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `matapel`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('matapel');
    }
};