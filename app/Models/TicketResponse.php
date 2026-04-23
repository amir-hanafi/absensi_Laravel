<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketResponse extends Model
{
    //
    protected $fillable = [
        'ticket_id',
        'responder_id',
        'message',
        'is_auto_reply'
    ];

    
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }
}
