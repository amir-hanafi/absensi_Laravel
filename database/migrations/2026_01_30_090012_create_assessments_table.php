<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * @class CreateAssessmentsTable
 * @brief Migration untuk membuat tabel assessments.
 *
 * Tabel ini menyimpan data penilaian siswa, termasuk siapa yang menilai,
 * siapa yang dinilai, tanggal penilaian, periode, dan catatan umum.
 */
return new class extends Migration
{
    /**
     * @brief Menjalankan proses migration.
     *
     * Method ini akan membuat tabel `assessments` dengan struktur:
     * - id : Primary key
     * - evaluator_id : Foreign key ke tabel users (siapa yang menilai)
     * - siswa_id : Foreign key ke tabel siswa (siapa yang dinilai)
     * - assessment_date : Tanggal penilaian dilakukan
     * - period : Periode penilaian (contoh: Semester 1 / Minggu 1 Jan)
     * - general_notes : Catatan umum terkait penilaian (opsional)
     * - timestamps : Kolom created_at dan updated_at
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {

            /// Primary key auto increment
            $table->id();

            /// Foreign key ke tabel users (evaluator / penilai)
            $table->foreignId('evaluator_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /// Foreign key ke tabel siswa (yang dinilai)
            $table->foreignId('siswa_id')
                ->constrained('siswa')
                ->cascadeOnDelete();

            /// Tanggal penilaian dilakukan
            $table->date('assessment_date');

            /// Periode penilaian (contoh: Semester 1 / Minggu 1 Jan)
            $table->string('period');

            /// Catatan umum terkait penilaian (opsional)
            $table->text('general_notes')->nullable();

            /// Kolom created_at dan updated_at
            $table->timestamps();
        });
    }

    /**
     * @brief Membatalkan migration.
     *
     * Method ini akan menghapus tabel `assessments`
     * jika migration di-rollback.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};