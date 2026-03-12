<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class AssessmentCategory
 * @brief Model Eloquent untuk tabel `assessment_categories`.
 *
 * Model ini merepresentasikan kategori penilaian, misalnya Disiplin,
 * Kerja Sama, Kreativitas, dll. Satu kategori dapat digunakan dalam
 * banyak detail penilaian.
 */
class AssessmentCategory extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'assessment_categories';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',        ///< Nama kategori penilaian
        'description', ///< Deskripsi kategori (opsional)
        'type',        ///< Tipe penilaian (Employee / Student)
        'is_active'    ///< Status aktif kategori (true/false)
    ];

    /**
     * @brief Relasi ke model AssessmentDetail.
     *
     * Mengambil semua detail penilaian yang terkait dengan kategori ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(AssessmentDetail::class, 'category_id');
    }
}