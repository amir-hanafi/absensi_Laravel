<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

    protected $fillable = [
        'qr_token_id',
        'user_id',
        'latitude',
        'longitude',
        'distance',
        'status',
        'scan_time',
        'jadwal_id'
    ];

    protected $casts = [
        'scan_time' => 'datetime'
    ];

    // relasi ke token
    public function qrToken()
    {
        return $this->belongsTo(QrToken::class);
    }

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
