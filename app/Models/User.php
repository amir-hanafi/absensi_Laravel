<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @class User
 * @brief Model Eloquent untuk tabel `users` dan autentikasi.
 *
 * Model ini merepresentasikan akun pengguna sistem, baik sebagai
 * siswa maupun guru. Termasuk relasi ke Siswa, Guru, dan Attendance.
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'username', ///< Nama pengguna unik
        'password', ///< Password pengguna
        'role',     ///< Peran pengguna (admin, guru, siswa)
    ];

    /**
     * @brief Atribut yang disembunyikan saat serialisasi.
     *
     * @var array
     */
    protected $hidden = [
        'password',       ///< Password terenkripsi
        'remember_token', ///< Token "ingat saya"
    ];

    /**
     * @brief Relasi ke model Siswa.
     *
     * Jika pengguna ini adalah siswa, relasi one-to-one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function siswa()
    {
        return $this->hasOne(Siswa::class);
    }

    /**
     * @brief Relasi ke model Guru.
     *
     * Jika pengguna ini adalah guru, relasi one-to-one.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    /**
     * @brief Relasi ke model Attendance.
     *
     * Mengambil semua absensi yang dilakukan pengguna ini.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}