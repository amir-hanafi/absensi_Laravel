<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Jadwal
 * @brief Model Eloquent untuk tabel `jadwal`.
 *
 * Model ini merepresentasikan jadwal pelajaran di sekolah,
 * termasuk hari, urutan jam, guru pengampu, mata pelajaran,
 * dan kelas terkait. Jadwal juga memiliki relasi ke QR token dan absensi.
 */
class Jadwal extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'jadwal';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'jadwal_sekolah_id',
        'kelas_id',
        'guru_id',
        'matapel_id'
    ];

    /**
     * @brief Relasi ke model Guru.
     *
     * Menunjukkan guru pengampu jadwal ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    /**
     * @brief Relasi ke model Matapel.
     *
     * Menunjukkan mata pelajaran yang diajarkan pada jadwal ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function matapel()
    {
        return $this->belongsTo(Matapel::class);
    }

    /**
     * @brief Relasi ke model Kelas.
     *
     * Menunjukkan kelas yang mengikuti jadwal ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * @brief Relasi ke model QrToken.
     *
     * Mengambil semua token QR yang terkait dengan jadwal ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function qrTokens()
    {
        return $this->hasMany(QrToken::class);
    }

    /**
     * @brief Relasi ke model Attendance.
     *
     * Mengambil semua absensi yang dilakukan pada jadwal ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function jadwalSekolah()
    {
        return $this->belongsTo(JadwalSekolah::class);
    }
}
