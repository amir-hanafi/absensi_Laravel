<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentDetail extends Model
{
    protected $table = 'assessment_details';

    protected $fillable = [
        'assessment_id',
        'category_id',
        'score',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // header assessment
    public function assessment()
    {
        return $this->belongsTo(Assessment::class, 'assessment_id');
    }

    // kategori penilaian
    public function category()
    {
        return $this->belongsTo(AssessmentCategory::class, 'category_id');
    }
}