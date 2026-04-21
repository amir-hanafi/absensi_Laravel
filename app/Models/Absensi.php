<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PointLedger;


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

    protected static function booted()
    {
        static::saved(function ($absensi) {

            // hanya proses jika status Alpha
            if ($absensi->status !== 'Alpha') {
                return;
            }

            // Cegah double penalti (kalau diupdate berkali-kali)
            $already = PointLedger::where('user_id', $absensi->user_id)
                ->where('description', 'Alpha')
                ->whereDate('created_at', $absensi->tanggal)
                ->exists();

            if ($already) {
                return;
            }

            // Ambil balance terakhir
            $last = PointLedger::where('user_id', $absensi->user_id)
                ->latest()
                ->first();

            $balance = $last ? $last->current_balance : 0;

            // 🔥 BESAR PENALTI (bisa kamu ubah)
            $penalty = -5;

            PointLedger::create([
                'user_id' => $absensi->user_id,
                'transaction_type' => 'PENALTY',
                'amount' => $penalty,
                'current_balance' => $balance + $penalty,
                'description' => 'Alpha',
            ]);
        });
    }

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
