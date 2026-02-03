<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = ['siswa_id', 'tanggal', 'status'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
