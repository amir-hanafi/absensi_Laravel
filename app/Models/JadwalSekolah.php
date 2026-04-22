<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class JadwalSekolah
 * @brief Model Eloquent untuk tabel `jadwal_sekolah`.
 *
 * Model ini merepresentasikan jadwal sekolah secara umum,
 * termasuk hari, urutan jam, jam mulai, dan jam selesai pelajaran.
 */
class JadwalSekolah extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'jadwal_sekolah';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'hari',        ///< Hari pelajaran (contoh: Senin)
        'jam_ke',      ///< Urutan jam ke-berapa
        'jam_mulai',   ///< Waktu mulai pelajaran
        'jam_selesai'  ///< Waktu selesai pelajaran
    ];

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}
