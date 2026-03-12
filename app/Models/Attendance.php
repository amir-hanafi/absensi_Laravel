<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Attendance
 * @brief Model Eloquent untuk tabel `attendances`.
 *
 * Model ini merepresentasikan data absensi berdasarkan scan QR,
 * termasuk informasi lokasi, status absensi, waktu scan, serta
 * relasi ke pengguna, jadwal, dan QR token.
 */
class Attendance extends Model
{
    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'qr_token_id', ///< ID token QR yang digunakan saat absensi
        'user_id',     ///< ID pengguna/siswa yang melakukan absensi
        'jadwal_id',   ///< ID jadwal terkait absensi
        'latitude',    ///< Koordinat latitude saat absensi
        'longitude',   ///< Koordinat longitude saat absensi
        'distance',    ///< Jarak dari lokasi yang diperbolehkan (opsional)
        'status',      ///< Status absensi ('valid' atau 'invalid')
        'scan_time'    ///< Waktu scan QR
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
     * @brief Relasi ke model Jadwal.
     *
     * Menunjukkan jadwal terkait dengan absensi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    /**
     * @brief Relasi ke model QrToken.
     *
     * Menunjukkan token QR yang digunakan untuk absensi ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function qrToken()
    {
        return $this->belongsTo(QrToken::class);
    }
}