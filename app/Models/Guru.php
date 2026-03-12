<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Guru
 * @brief Model Eloquent untuk tabel `guru`.
 *
 * Model ini merepresentasikan guru di sekolah, termasuk informasi
 * pribadi, relasi ke user, kelas yang diajar, dan mata pelajaran
 * yang diampu.
 */
class Guru extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'guru';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'kode_guru', ///< Kode unik guru
        'nama',      ///< Nama guru
        'no_hp',     ///< Nomor HP guru
        'user_id',   ///< ID user terkait
    ];

    /**
     * @brief Relasi ke model User.
     *
     * Menunjukkan akun pengguna terkait guru ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @brief Relasi ke model Kelas.
     *
     * Mengambil semua kelas yang diajar oleh guru ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }

    /**
     * @brief Relasi banyak-ke-banyak ke model Matapel.
     *
     * Menunjukkan mata pelajaran yang diampu oleh guru ini.
     * Relasi menggunakan tabel pivot `guru_matapel`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function matapel()
    {
        return $this->belongsToMany(Matapel::class, 'guru_matapel');
    }
}