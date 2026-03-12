<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateAttendancesTable
 * @brief Migration untuk membuat tabel attendances.
 *
 * Tabel ini menyimpan data absensi siswa atau pengguna lain
 * berdasarkan scan QR. Mencatat lokasi, status absensi, dan waktu scan.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `attendances` dengan struktur:
     * - id : Primary key
     * - qr_token_id : Foreign key ke tabel qr_tokens
     * - user_id : Foreign key ke tabel users
     * - latitude : Koordinat latitude saat absensi
     * - longitude : Koordinat longitude saat absensi
     * - distance : Jarak dari lokasi yang diperbolehkan (opsional)
     * - status : Status absensi ('valid' atau 'invalid')
     * - scan_time : Waktu scan QR
     * - jadwal_id : Foreign key ke tabel jadwal
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Foreign key ke tabel qr_tokens
            /// Menentukan token QR yang digunakan saat absensi
            $table->foreignId('qr_token_id')
                ->constrained('qr_tokens')
                ->cascadeOnDelete();

            /// Foreign key ke tabel users
            /// Menentukan pengguna yang melakukan absensi
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /// Koordinat latitude saat absensi
            $table->double('latitude', 10, 7);

            /// Koordinat longitude saat absensi
            $table->double('longitude', 10, 7);

            /// Jarak dari lokasi yang diperbolehkan (opsional)
            $table->double('distance')->nullable();

            /// Status absensi ('valid' atau 'invalid')
            $table->enum('status', ['valid', 'invalid']);

            /// Waktu scan QR
            $table->dateTime('scan_time');

            /// Foreign key ke tabel jadwal
            /// Menentukan jadwal yang terkait dengan absensi
            $table->foreignId('jadwal_id')
                ->constrained('jadwal')
                ->cascadeOnDelete();

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });

    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `attendances`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};