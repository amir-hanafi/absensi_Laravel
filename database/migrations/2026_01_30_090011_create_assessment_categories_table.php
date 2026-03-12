<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateAssessmentCategoriesTable
 * @brief Migration untuk membuat tabel assessment_categories.
 *
 * Tabel ini digunakan untuk menyimpan kategori penilaian, misalnya
 * Disiplin, Kerja Sama, Kreativitas, dll. Setiap kategori dapat
 * digunakan untuk menilai Employee atau Student.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `assessment_categories` dengan struktur:
     * - id : Primary key
     * - name : Nama kategori penilaian
     * - description : Deskripsi kategori (opsional)
     * - type : Tipe pengguna yang dinilai (Employee / Student, opsional)
     * - is_active : Status aktif kategori (default true)
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('assessment_categories', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Nama kategori penilaian (contoh: Disiplin, Kerja Sama)
            $table->string('name');

            /// Deskripsi kategori (opsional)
            $table->text('description')->nullable();

            /// Tipe pengguna yang dinilai (Employee / Student)
            $table->string('type')->nullable();

            /// Status kategori, aktif atau tidak
            $table->boolean('is_active')->default(true);

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `assessment_categories`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_categories');
    }
};