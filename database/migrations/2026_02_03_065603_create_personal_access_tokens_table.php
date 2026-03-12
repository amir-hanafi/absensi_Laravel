<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreatePersonalAccessTokensTable
 * @brief Migration untuk membuat tabel personal_access_tokens.
 *
 * Tabel ini menyimpan token akses pribadi untuk autentikasi API
 * menggunakan Laravel Sanctum. Token dapat memiliki kemampuan
 * (abilities) dan masa kadaluarsa.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `personal_access_tokens` dengan struktur:
     * - id : Primary key
     * - tokenable : Polimorfik, relasi ke model yang memiliki token
     * - name : Nama token
     * - token : Token unik (64 karakter)
     * - abilities : Kemampuan token (opsional)
     * - last_used_at : Waktu terakhir token digunakan (opsional)
     * - expires_at : Waktu kadaluarsa token (opsional)
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('personal_access_tokens', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Kolom polimorfik untuk relasi ke model yang memiliki token
            $table->morphs('tokenable');

            /// Nama token
            $table->text('name');

            /// Token unik, panjang 64 karakter
            $table->string('token', 64)->unique();

            /// Kemampuan token (opsional)
            $table->text('abilities')->nullable();

            /// Waktu terakhir token digunakan (opsional)
            $table->timestamp('last_used_at')->nullable();

            /// Waktu kadaluarsa token (opsional), diindeks
            $table->timestamp('expires_at')->nullable()->index();

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `personal_access_tokens`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_access_tokens');
    }
};