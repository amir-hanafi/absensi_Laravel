<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateAbsensiTable
 * @brief Migration untuk membuat tabel absensi.
 *
 * Tabel ini menyimpan data absensi harian siswa atau pengguna,
 * termasuk status kehadiran, tanggal, dan relasi ke record attendance.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `absensi` dengan struktur:
     * - id : Primary key
     * - user_id : Foreign key ke tabel users (pengguna/siswa yang absen)
     * - attendance_id : Foreign key ke tabel attendances (opsional, nullable)
     * - tanggal : Tanggal absensi
     * - status : Status kehadiran ('Hadir', 'Sakit', 'Ijin', 'Alpha')
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Foreign key ke tabel users
            /// Menunjukkan pengguna/siswa yang melakukan absensi
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /// Foreign key ke tabel attendances (opsional)
            /// Jika record attendance dihapus, kolom ini akan diset null
            $table->foreignId('attendance_id')
                ->nullable()
                ->constrained('attendances')
                ->nullOnDelete();

            /// Tanggal absensi
            $table->date('tanggal');

            /// Status kehadiran
            /// Pilihan: Hadir, Sakit, Ijin, Alpha
            $table->enum('status', [
                'Hadir',
                'Sakit',
                'Ijin',
                'Alpha'
            ]);

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `absensi`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};