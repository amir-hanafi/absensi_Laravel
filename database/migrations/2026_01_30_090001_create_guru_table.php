<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateGuruTable
 * @brief Migration untuk membuat tabel guru pada database.
 *
 * Tabel ini menyimpan data guru yang terhubung dengan tabel users
 * untuk keperluan autentikasi login.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `guru` dengan beberapa kolom:
     * - id : Primary key
     * - kode_guru : Kode unik untuk setiap guru
     * - nama : Nama lengkap guru
     * - no_hp : Nomor handphone guru
     * - user_id : Foreign key yang terhubung ke tabel users
     * - timestamps : Kolom created_at dan updated_at
     *
     * Relasi:
     * - user_id → users.id
     * - Jika user dihapus maka data guru juga ikut terhapus (cascade delete)
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('guru', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Kode unik untuk identitas guru
            $table->string('kode_guru')->unique();

            /// Nama lengkap guru
            $table->string('nama');

            /// Nomor handphone guru
            $table->string('no_hp');

            /// Relasi ke tabel users
            /// Jika user dihapus maka data guru ikut terhapus
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `guru`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('guru');
    }
};