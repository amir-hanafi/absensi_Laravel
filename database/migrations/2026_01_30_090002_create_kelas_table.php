<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateKelasTable
 * @brief Migration untuk membuat tabel kelas pada database.
 *
 * Tabel ini digunakan untuk menyimpan data kelas yang diajar oleh guru.
 * Setiap kelas memiliki relasi dengan satu guru melalui kolom guru_id.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `kelas` dengan struktur:
     * - id : Primary key
     * - nama_kelas : Nama kelas
     * - guru_id : Foreign key yang terhubung dengan tabel guru
     * - timestamps : Kolom created_at dan updated_at
     *
     * Relasi:
     * - guru_id → guru.id
     * - Jika data guru dihapus maka data kelas juga ikut terhapus (cascade delete)
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// 🔥 Tingkat kelas (10, 11, 12)
            $table->integer('tingkat_kelas');

            /// Nama kelas (contoh: X RPL 1, XI TKJ 2, dll)
            $table->string('nama_kelas');

            /// Relasi ke tabel guru
            $table->foreignId('guru_id')->constrained('guru')->cascadeOnDelete();

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `kelas`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
