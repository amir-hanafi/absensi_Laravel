<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matapel extends Model
{
    use HasFactory;

    protected $table = 'matapel';

    protected $fillable = [
        'mata_pelajaran',
        'guru_id',
    ];

    // Relasi ke Guru
    public function guru()
    {
        return $this->belongsToMany(Guru::class, 'guru_matapel');
    }
}
