<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreatePlacesTable
 * @brief Migration untuk membuat tabel places.
 *
 * Tabel ini digunakan untuk menyimpan data lokasi yang diperbolehkan
 * untuk melakukan absensi. Data yang disimpan meliputi nama lokasi,
 * koordinat latitude dan longitude, serta radius area yang diizinkan.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `places` yang menyimpan informasi lokasi absensi.
     *
     * Struktur tabel:
     * - id : Primary key
     * - name : Nama lokasi
     * - latitude : Koordinat lintang lokasi
     * - longitude : Koordinat bujur lokasi
     * - allowed_radius : Radius area yang diperbolehkan untuk absensi (dalam meter)
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('places', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Nama lokasi absensi
            $table->string('name');

            /// Koordinat latitude lokasi
            $table->decimal('latitude', 10, 7);

            /// Koordinat longitude lokasi
            $table->decimal('longitude', 10, 7);

            /// Radius area yang diperbolehkan untuk absensi (dalam meter)
            $table->integer('allowed_radius'); // dalam meter

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `places`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('places');
    }
};