<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateGuruMatapelTable
 * @brief Migration untuk membuat tabel guru_matapel.
 *
 * Tabel ini merupakan tabel relasi (pivot table) yang menghubungkan
 * guru dengan mata pelajaran yang diajarkan. Satu guru dapat mengajar
 * beberapa mata pelajaran, dan satu mata pelajaran dapat diajarkan oleh
 * beberapa guru.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `guru_matapel` yang menyimpan
     * relasi antara guru dan mata pelajaran.
     *
     * Struktur tabel:
     * - id : Primary key
     * - guru_id : Foreign key yang mengarah ke tabel guru
     * - matapel_id : Foreign key yang mengarah ke tabel matapel
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('guru_matapel', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Foreign key ke tabel guru
            /// Menunjukkan guru yang mengajar
            $table->foreignId('guru_id')
                  ->constrained('guru')
                  ->cascadeOnDelete();

            /// Foreign key ke tabel matapel
            /// Menunjukkan mata pelajaran yang diajarkan
            $table->foreignId('matapel_id')
                  ->constrained('matapel')
                  ->cascadeOnDelete();

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `guru_matapel`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('guru_matapel');
    }
};