<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * @class Assessment
 * @brief Model Eloquent untuk tabel `assessments`.
 *
 * Model ini merepresentasikan penilaian yang dilakukan oleh evaluator
 * terhadap siswa pada periode tertentu. Setiap penilaian memiliki
 * detail kategori penilaian.
 */
class Assessment extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'assessments';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'evaluator_id',    ///< ID evaluator (user yang menilai)
        'siswa_id',        ///< ID siswa yang dinilai
        'assessment_date', ///< Tanggal penilaian
        'period',          ///< Periode penilaian (contoh: Semester 1 / Minggu 1 Jan)
        'general_notes',   ///< Catatan umum (opsional)
    ];

    /**
     * @brief Konversi tipe atribut otomatis.
     *
     * @var array
     */
    protected $casts = [
        'assessment_date' => 'date', ///< Mengubah kolom menjadi objek Carbon (tanggal)
    ];

    /**
     * @brief Relasi ke model Siswa.
     *
     * Menunjukkan siswa yang dinilai.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * @brief Relasi ke model AssessmentDetail.
     *
     * Mengambil semua detail kategori penilaian untuk assessment ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(AssessmentDetail::class, 'assessment_id');
    }
}