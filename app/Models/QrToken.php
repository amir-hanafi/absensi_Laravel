<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $table = 'qr_tokens';

    protected $fillable = [
        'token',
        'jadwal_id',
        'expired_at'
    ];

    // relasi ke jadwal
    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    // relasi ke attendance
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}