<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal'; 
    protected $fillable = [
        'hari',
        'jam_ke',
        'guru_id',
        'matapel_id',
        'kelas_id'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function matapel()
    {
        return $this->belongsTo(Matapel::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function qrTokens()
    {
        return $this->hasMany(QrToken::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}