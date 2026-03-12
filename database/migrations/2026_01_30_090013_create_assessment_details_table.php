<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateAssessmentDetailsTable
 * @brief Migration untuk membuat tabel assessment_details.
 *
 * Tabel ini menyimpan detail penilaian untuk setiap siswa, 
 * termasuk kategori penilaian dan skor yang diberikan.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `assessment_details` dengan struktur:
     * - id : Primary key
     * - assessment_id : Foreign key ke tabel assessments (penilaian utama)
     * - category_id : Foreign key ke tabel assessment_categories (kategori penilaian)
     * - score : Skor yang diberikan (contoh: 1-5 atau 0-100)
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('assessment_details', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Foreign key ke tabel assessments (penilaian utama)
            $table->foreignId('assessment_id')
                ->constrained('assessments')
                ->cascadeOnDelete();

            /// Foreign key ke tabel assessment_categories (kategori penilaian)
            $table->foreignId('category_id')
                ->constrained('assessment_categories')
                ->cascadeOnDelete();

            /// Skor penilaian (contoh: 1-5 atau 0-100)
            $table->decimal('score', 5, 2);

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `assessment_details`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_details');
    }
};