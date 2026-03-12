<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @class Matapel
 * @brief Model Eloquent untuk tabel `matapel`.
 *
 * Model ini merepresentasikan mata pelajaran di sekolah.
 * Satu mata pelajaran bisa diampu oleh banyak guru melalui relasi many-to-many.
 */
class Matapel extends Model
{
    use HasFactory;

    /// Nama tabel yang digunakan
    protected $table = 'matapel';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'mata_pelajaran', ///< Nama mata pelajaran
        'guru_id',        ///< ID guru (opsional, bisa dihubungkan lewat pivot)
    ];

    /**
     * @brief Relasi banyak-ke-banyak ke model Guru.
     *
     * Menunjukkan guru yang mengampu mata pelajaran ini.
     * Relasi menggunakan tabel pivot `guru_matapel`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_matapel');
    }
}