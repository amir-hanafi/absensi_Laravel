<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Assessment extends Model
{
    protected $table = 'assessments';

    protected $fillable = [
        'evaluator_id',
        'siswa_id',
        'assessment_date',
        'period',
        'general_notes',
    ];

    protected $casts = [
        'assessment_date' => 'date',
    ];


    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function details()
    {
        return $this->hasMany(AssessmentDetail::class, 'assessment_id');
    }
}
