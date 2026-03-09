<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalSekolah extends Model
{
    protected $table = 'jadwal_sekolah';

    protected $fillable = [
        'hari',
        'jam_ke',
        'jam_mulai',
        'jam_selesai'
    ];
}