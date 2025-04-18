<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendee extends Model
{
    use HasFactory;

    /* 
    - This defines that an Attendee record "belongs to" a User
    - It corresponds to the foreignIdFor(User::class) in the events migration
    - We can access the user who is attending with $attendee->user
    */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* 
    - This defines that an Attendee record "belongs to" an Event
    - It corresponds to the foreignIdFor(Event::class) in the events migration
    - We can access the event being attended with $attendee->event
    */
    public function event():BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
