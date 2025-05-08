<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    use CanLoadRelationships;
 
    private array $relations = ['user', 'attendees', 'attendees.user'];

    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->authorizeResource(Event::class, 'event');
    }

    // all events
    public function index()
    {
       // return Event::all(); // this returns the array without meta data
       // return EventResource::collection(Event::all()); // this returns an object with meta data and then a data field has the array with the actual data.
        
        // EventResource --> controlo los campos que se mostraran en la respuesta
        // with('user') --> agrega la info del usuario a la respuesta de los eventos, eso debe estar configurado en el resource
        // return EventResource::collection(Event::with('user')->get());
        // return EventResource::collection(Event::with('user')->paginate());

        // $query = Event::query(); // Gets a fresh query builder instance
        // if (request()->has('name')) { // Checks for a URL parameter like ?name=Concert
        //     $query->where('name', 'like', '%' . request('name') . '%'); // Chains conditions 
        // }
        // $events = $query->with('user')->paginate(); // Executes the query to get data
        // return EventResource::collection($events);
        
        $query = $this->loadRelationships(Event::query()); // Checks for a URL parameter like ?include=user,attendees,attendees.user
        $events =  $query->latest()->paginate();
        return EventResource::collection($events);
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
            'user_id' => $request->user()->id
        ]);

       // return $event;
        return new EventResource($event);

    }


    // public function show($id)
    // {
    //     $event = Event::find($id);
    //     if (!$event) {
    //         return response()->json(['message' => 'Event not found'], 404);
    //     }
    //     return $event;
    // }
    public function show(Event $event) //Route Model Binding 
    {
        //return $event;
        //return new EventResource($event);
        $event->load('user','attendees'); // cargo en la respuesta de los eventos la info del user y de los attendees, eso tiene que estar configurado en el resource
        return new EventResource($event);
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
       //return $event;
        return new EventResource($event);

    }

    public function destroy(Event $event) //Route Model Binding 
    {
        $event->delete();
        return response(status: 204);
    }
}

/* 
note: 

1) EventResource: this one adds "data" meta field to the response.

2) "Conditional Relationship Loading" or "Eager Loading Control" in Laravel:

- whenLoaded() → Conditional attribute inclusion (in the resource)

- with()/load() → Eager loading (in the controller)

relationships are loaded in the controller (via with() or load()), and whenLoaded in the EventResource checks if they were pre-loaded there—only including them in the API response if they were explicitly requested.

3) return EventResource::collection($events) (in index) vs return new EventResource() (in all the other methods):

- new EventResource($event) because each API response needs a fresh transformer instance to safely convert your model data to JSON.

- EventResource::collection() is a static factory method designed specifically to transform paginated/collections of models. It Automatically creates resource instances for each item internally.

Whereas new EventResource() is for single-model transformation, ::collection() optimizes bulk operations. Both approaches create resources, but collections use static calls for cleaner syntax with multiple items.

 */
