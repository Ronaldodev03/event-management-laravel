<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;


    /* 
    - This defines that an Event "belongs to" a User (the creator/organizer)
    - It corresponds to the foreignIdFor(User::class) in the events migration
    - We can access the user who created the event with $event->user
    */
    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /* 
    - This defines that an Event "has many" Attendees
    - We can access all attendees of an event with $event->attendees
    */
    public function attendees():HasMany
    {
        return $this->hasMany(Attendee::class);
    }
}
