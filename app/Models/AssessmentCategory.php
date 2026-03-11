<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssessmentCategory extends Model
{
    protected $table = 'assessment_categories';

    protected $fillable = [
        'name',
        'description',
        'type',
        'is_active'
    ];

    // kategori punya banyak detail penilaian
    public function details()
    {
        return $this->hasMany(AssessmentDetail::class, 'category_id');
    }
}