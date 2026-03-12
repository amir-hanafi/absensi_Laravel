<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class QrToken
 * @brief Model Eloquent untuk tabel `qr_tokens`.
 *
 * Model ini merepresentasikan token QR yang digunakan untuk absensi
 * berbasis scan. Setiap token terkait dengan jadwal tertentu dan
 * dapat memiliki banyak record absensi.
 */
class QrToken extends Model
{
    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'jadwal_id', ///< ID jadwal terkait
        'token',     ///< Token QR unik
        'expired_at' ///< Waktu kadaluarsa token
    ];

    /**
     * @brief Relasi ke model Jadwal.
     *
     * Menunjukkan jadwal yang terkait dengan token QR ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    /**
     * @brief Relasi ke model Attendance.
     *
     * Mengambil semua absensi yang dilakukan menggunakan token QR ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}