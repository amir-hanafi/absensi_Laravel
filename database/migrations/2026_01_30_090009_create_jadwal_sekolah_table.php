<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateJadwalSekolahTable
 * @brief Migration untuk membuat tabel jadwal_sekolah.
 *
 * Tabel ini menyimpan informasi jadwal waktu pelajaran di sekolah,
 * seperti hari pelaksanaan, jam pelajaran ke berapa, serta waktu
 * mulai dan selesai setiap jam pelajaran.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `jadwal_sekolah` yang berisi
     * data waktu pelajaran di sekolah.
     *
     * Struktur tabel:
     * - id : Primary key
     * - hari : Hari pelaksanaan jadwal
     * - jam_ke : Jam pelajaran ke berapa
     * - jam_mulai : Waktu mulai pelajaran
     * - jam_selesai : Waktu selesai pelajaran
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('jadwal_sekolah', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Hari pelaksanaan jadwal pelajaran
            $table->string('hari');

            /// Menunjukkan jam pelajaran ke berapa
            $table->integer('jam_ke');

            /// Waktu mulai pelajaran
            $table->time('jam_mulai');

            /// Waktu selesai pelajaran
            $table->time('jam_selesai');

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `jadwal_sekolah`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_sekolah');
    }
};