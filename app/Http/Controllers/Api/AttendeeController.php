<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function index(Event $event)    // the event is part of the url, that's why I can take it here with Route Model Binding 
    {
        $attendees = $event->attendees()->latest();    // get latest attendees of an event
        return AttendeeResource::collection($attendees->paginate()); // return paginated collection
    }

    public function store(Request $request, Event $event)   //Route Model Binding  
    {
        $attendee = $event->attendees()->create([
            'user_id' => 1 // fixed to 1 for now
        ]);

        return new AttendeeResource($attendee);
    }

    public function show(Event $event, Attendee $attendee) //Route Model Binding 
    {
        return new AttendeeResource($attendee);
    }

    public function destroy(string $event, Attendee $attendee) //Route Model Binding 
    {
         $attendee->delete();
 
         return response(status: 204);
    }
}
