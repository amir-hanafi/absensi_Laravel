<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class AssessmentDetail
 * @brief Model Eloquent untuk tabel `assessment_details`.
 *
 * Model ini merepresentasikan detail penilaian untuk setiap siswa,
 * termasuk kategori penilaian dan skor yang diberikan.
 */
class AssessmentDetail extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'assessment_details';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'assessment_id', ///< ID penilaian utama (assessments)
        'category_id',   ///< ID kategori penilaian
        'score',         ///< Skor yang diberikan
    ];

    /**
     * @brief Konversi tipe atribut otomatis.
     *
     * @var array
     */
    protected $casts = [
        'score' => 'float', ///< Skor di-cast menjadi float
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    /**
     * @brief Relasi ke model Assessment (header penilaian).
     *
     * Mengambil data penilaian utama yang dimiliki detail ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    /**
     * @brief Relasi ke model AssessmentCategory (kategori penilaian).
     *
     * Menunjukkan kategori penilaian yang terkait dengan detail ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(AssessmentCategory::class, 'category_id');
    }
}