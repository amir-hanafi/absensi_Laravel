<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateJadwalTable
 * @brief Migration untuk membuat tabel jadwal.
 *
 * Tabel ini menyimpan jadwal pelajaran yang berisi informasi hari,
 * jam pelajaran, kelas, guru, dan mata pelajaran yang diajarkan.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `jadwal` yang berisi data jadwal pelajaran.
     *
     * Struktur tabel:
     * - id : Primary key
     * - hari : Hari pelajaran berlangsung
     * - jam_ke : Jam pelajaran ke berapa
     * - kelas_id : Relasi ke tabel kelas
     * - guru_id : Relasi ke tabel guru
     * - matapel_id : Relasi ke tabel matapel
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Hari pelaksanaan pelajaran (contoh: Senin, Selasa, dll)
            $table->string('hari');

            /// Menunjukkan jam pelajaran ke berapa
            $table->integer('jam_ke');

            /// Foreign key ke tabel kelas
            /// Menentukan kelas yang mengikuti pelajaran
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            /// Foreign key ke tabel guru
            /// Menentukan guru yang mengajar
            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnDelete();

            /// Foreign key ke tabel matapel
            /// Menentukan mata pelajaran yang diajarkan
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
     * Method ini akan menghapus tabel `jadwal`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};