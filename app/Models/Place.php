<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Place
 * @brief Model Eloquent untuk tabel `places`.
 *
 * Model ini merepresentasikan lokasi yang dapat digunakan untuk
 * validasi absensi berbasis lokasi. Mencakup nama tempat,
 * koordinat, dan radius maksimal yang diperbolehkan.
 */
class Place extends Model
{
    /// Nama tabel yang digunakan
    protected $table = 'places';

    /**
     * @brief Atribut yang dapat diisi secara massal.
     *
     * @var array
     */
    protected $fillable = [
        'name',           ///< Nama tempat/lokasi
        'latitude',       ///< Koordinat latitude tempat
        'longitude',      ///< Koordinat longitude tempat
        'allowed_radius'  ///< Radius maksimal yang diperbolehkan (meter)
    ];
}