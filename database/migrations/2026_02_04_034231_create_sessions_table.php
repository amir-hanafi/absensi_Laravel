<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateSessionsTable
 * @brief Migration untuk membuat tabel sessions.
 *
 * Tabel ini digunakan untuk menyimpan sesi pengguna aplikasi.
 * Informasi yang disimpan meliputi user, IP, user agent, payload, dan aktivitas terakhir.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `sessions` dengan struktur:
     * - id : Primary key, ID sesi
     * - user_id : Foreign key ke tabel users (opsional)
     * - ip_address : Alamat IP pengguna saat sesi dibuat (opsional)
     * - user_agent : User agent browser / perangkat pengguna (opsional)
     * - payload : Data sesi yang diserialisasi
     * - last_activity : Timestamp aktivitas terakhir
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {

            /// ID sesi sebagai primary key
            $table->string('id')->primary();

            /// Foreign key ke tabel users (opsional)
            $table->foreignId('user_id')->nullable()->index();

            /// Alamat IP pengguna (opsional)
            $table->string('ip_address', 45)->nullable();

            /// User agent browser atau perangkat (opsional)
            $table->text('user_agent')->nullable();

            /// Payload sesi yang diserialisasi
            $table->longText('payload');

            /// Waktu aktivitas terakhir, diindeks
            $table->integer('last_activity')->index();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `sessions`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};