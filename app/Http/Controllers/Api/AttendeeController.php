<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Resources\AttendeeResource;
use App\Models\Attendee;
use App\Models\Event;
use Illuminate\Http\Request;

class AttendeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show', 'update']);
        $this->authorizeResource(Attendee::class, 'attendee');
    }

    public function index(Event $event)    // the event is part of the url, that's why I can take it here with Route Model Binding 
    {
        $attendees = $event->attendees()->latest();    // get latest attendees of an event
        return AttendeeResource::collection($attendees->paginate()); // return paginated collection
    }

    public function store(Request $request, Event $event)   //Route Model Binding  
    {
        $attendee = $event->attendees()->create([
            'user_id' => $request->user()->id
        ]);

        return new AttendeeResource($attendee);
    }

    public function show(Event $event, Attendee $attendee) //Route Model Binding 
    {
        return new AttendeeResource($attendee);
    }

    public function destroy(Event  $event, Attendee $attendee) //Route Model Binding 
    {
          // $this->authorize('delete-attendee', [$event, $attendee]);
         $attendee->delete();
 
         return response(status: 204);
    }
}
