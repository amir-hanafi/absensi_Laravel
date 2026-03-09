<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'qr_token_id',
        'user_id',
        'jadwal_id',
        'latitude',
        'longitude',
        'distance',
        'status',
        'scan_time'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal::class);
    }

    public function qrToken()
    {
        return $this->belongsTo(QrToken::class);
    }
}
