<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    //
    protected $fillable = [
        'reporter_id',
        'operator_id',
        'subject',
        'description',
        'category_id',
        'priority',
        'status'
    ];

    

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }

    public function rating()
    {
        return $this->hasOne(SatisfactionRating::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
