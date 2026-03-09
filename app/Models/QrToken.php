<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrToken extends Model
{
    protected $fillable = [
        'jadwal_id',
        'token',
        'expired_at'
    ];

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}