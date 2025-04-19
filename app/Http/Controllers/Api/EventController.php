<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    // all events
    public function index()
    {
        //
    }


    public function store(Request $request)
    {

        // $validatedData = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'start_time' => 'required|date',
        //     'end_time' => 'required|date|after:start_time'
        // ]);
        // $validatedData['user_id'] = 1; // fixed to 1 for now
        // $event = Event::create($validatedData);

        $event = Event::create([
            ...$request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time'
            ]),
            'user_id' => 1 // fixed to 1 for now
        ]);

        return $event;

    }


   
    public function show(Event $event) //Route Model Binding 
    {
        //
    }

    // public function update(Request $request, $eventId)
    // {
    //     $event = Event::findOrFail($eventId);
    //     $event->update(
    //         $request->validate([
    //             'name' => 'sometimes|string|max:255',
    //             'description' => 'nullable|string',
    //             'start_time' => 'sometimes|date',
    //             'end_time' => 'sometimes|date|after:start_time'
    //         ])
    //     );
    //     return $event;
    // }
    public function update(Request $request, Event $event) //Route Model Binding 
    {
        $event->update(
            $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'sometimes|date',
                'end_time' => 'sometimes|date|after:start_time'
            ])
        );
        //note: 'sometimes' is needed because you don't have to update all the fields.
        //      with 'sometimes' it will be validated only if the value is there, 
        //      otherwise it will pass to the othe value.
        return $event;

    }

    public function destroy(Event $event) //Route Model Binding 
    {
        $event->delete();
        return response(status: 204);
    }
}
