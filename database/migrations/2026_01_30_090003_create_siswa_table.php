<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateSiswaTable
 * @brief Migration untuk membuat tabel siswa pada database.
 *
 * Tabel ini menyimpan data siswa yang terhubung dengan tabel kelas
 * dan tabel users untuk keperluan autentikasi login.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `siswa` dengan struktur:
     * - id : Primary key
     * - nis : Nomor Induk Siswa (unik)
     * - nama : Nama lengkap siswa
     * - kelas_id : Foreign key yang menghubungkan siswa dengan kelas
     * - user_id : Foreign key yang menghubungkan siswa dengan akun user
     * - timestamps : Kolom created_at dan updated_at
     *
     * Relasi:
     * - kelas_id → kelas.id
     * - user_id → users.id
     *
     * Jika data kelas atau user dihapus, maka data siswa juga akan terhapus
     * karena menggunakan cascade delete.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {

            $table->id();

            $table->string('nis')->unique();
            $table->string('nama');

            /// 🔥 Tahun masuk (penting untuk hitung tingkat)
            $table->year('tahun_masuk');

            /// 🔥 Tahun ajaran (opsional, misal 2025/2026)
            

            /// Relasi ke kelas (boleh berubah tiap tahun)
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->nullOnDelete();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');

            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `siswa`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
