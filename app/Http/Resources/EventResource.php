<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'descriptionm'=>$this->description,
            'start_time'=>$this->start_time,
            'end_time'=>$this->end_time,
            'user'=> new UserResource($this->whenLoaded('user')), // The whenLoaded method checks if a relationship was loaded (via with() or load()) in the Eloquent query (done in the controller) before including it in the API response.
            'attendees'=> AttendeeResource::collection($this->whenLoaded('attendees')) // The whenLoaded method checks if a relationship was loaded (via with() or load()) in the Eloquent query (done in the controller) before including it in the API response.
        ];
    }
}

