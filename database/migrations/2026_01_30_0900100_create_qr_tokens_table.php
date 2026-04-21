<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateQrTokensTable
 * @brief Migration untuk membuat tabel qr_tokens.
 *
 * Tabel ini menyimpan token QR untuk absensi siswa.
 * Setiap token terkait dengan jadwal tertentu dan memiliki masa berlaku.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `qr_tokens` dengan struktur:
     * - id : Primary key
     * - jadwal_id : Foreign key ke tabel jadwal (jadwal terkait QR)
     * - token : Token QR unik
     * - expired_at : Waktu kadaluarsa token QR
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('qr_tokens', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Foreign key ke tabel jadwal
            /// Menentukan jadwal terkait token QR
            // $table->foreignId('jadwal_id')
            //     ->constrained('jadwal')
            //     ->cascadeOnDelete();

            /// Token QR unik
            $table->string('token')->unique();

            /// Waktu kadaluarsa token QR
            $table->dateTime('expired_at');

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });

    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `qr_tokens`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_tokens');
    }
};