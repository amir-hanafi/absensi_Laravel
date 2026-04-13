<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserToken extends Model
{
    //
    protected $fillable = [
        'user_id',
        'item_id',
        'status'
    ];
}
