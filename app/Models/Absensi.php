<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Absensi
 * @brief Model Eloquent untuk tabel `absensi`.
 *
 * Model ini merepresentasikan data absensi harian siswa atau pengguna,
 * termasuk status kehadiran, tanggal, dan relasi ke record attendance.
 */
class Absensi extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'absensi';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',       ///< ID pengguna/siswa yang absen
        'tanggal',       ///< Tanggal absensi
        'status',        ///< Status kehadiran (Hadir, Sakit, Ijin, Alpha)
        'attendance_id'  ///< ID relasi ke tabel attendances (opsional)
    ];

    /**
     * @brief Relasi ke model User.
     *
     * Menunjukkan pengguna atau siswa yang melakukan absensi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @brief Relasi ke model Attendance.
     *
     * Menunjukkan record attendance terkait, jika ada.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}