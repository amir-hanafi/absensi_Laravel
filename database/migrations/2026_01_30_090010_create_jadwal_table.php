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

            $table->id();

            // ✅ RELASI KE JADWAL SEKOLAH
            $table->foreignId('jadwal_sekolah_id')
                ->constrained('jadwal_sekolah')
                ->cascadeOnDelete();

            // kelas
            $table->foreignId('kelas_id')
                ->constrained('kelas')
                ->cascadeOnDelete();

            // guru
            $table->foreignId('guru_id')
                ->constrained('guru')
                ->cascadeOnDelete();

            // mata pelajaran
            $table->foreignId('matapel_id')
                ->constrained('matapel')
                ->cascadeOnDelete();

            $table->timestamps();

            // 🔥 OPTIONAL (disarankan)
            $table->unique(['jadwal_sekolah_id', 'kelas_id']);
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
