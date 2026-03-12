<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Kelas
 * @brief Model Eloquent untuk tabel `kelas`.
 *
 * Model ini merepresentasikan kelas di sekolah, termasuk nama kelas
 * dan guru wali. Satu kelas dapat memiliki banyak siswa.
 */
class Kelas extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'kelas';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'nama_kelas', ///< Nama kelas (contoh: 10 IPA 1)
        'guru_id',    ///< ID guru wali kelas
    ];

    /**
     * @brief Relasi ke model Guru.
     *
     * Menunjukkan guru wali kelas ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * @brief Relasi ke model Siswa.
     *
     * Mengambil semua siswa yang tergabung dalam kelas ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}