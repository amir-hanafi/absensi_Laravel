<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $fillable = [
        'tanggal',
        'guru_id',
        'matapel_id'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function matapel()
    {
        return $this->belongsTo(Matapel::class);
    }
}