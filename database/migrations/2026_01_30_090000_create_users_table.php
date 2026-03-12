<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateUsersTable
 * @brief Migration untuk membuat tabel users pada database.
 *
 * Tabel ini digunakan untuk menyimpan data akun pengguna
 * seperti admin, guru, dan siswa yang dapat mengakses sistem.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `users` beserta kolom-kolomnya.
     *
     * Struktur tabel:
     * - id : Primary key
     * - username : Nama pengguna yang unik
     * - password : Password yang sudah di-hash
     * - role : Peran pengguna (admin, guru, siswa)
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Username unik untuk login
            $table->string('username')->unique();

            /// Password pengguna (biasanya disimpan dalam bentuk hash)
            $table->string('password');

            /// Role pengguna dalam sistem
            /// admin  : pengelola sistem
            /// guru   : pengajar
            /// siswa  : peserta didik
            $table->enum('role', ['admin', 'guru', 'siswa']);

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini digunakan untuk menghapus tabel `users`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};