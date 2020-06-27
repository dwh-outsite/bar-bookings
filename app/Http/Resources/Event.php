<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'event_type_id' => $this->event_type_id,
            'name' => $this->name,
            'capacity' => $this->capacity,
            'available_seats' => $this->availableSeats(),
            'available_twoseats' => $this->availableTwoseats(),
            'start' => $this->start,
            'end' => $this->end,
            'created_at' => $this->created_at,
        ];
    }
}
