<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Meetups extends JsonResource
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
            'name' => $this->name, 
            'cover_path' => asset(str_replace('public/', '', $this->cover_path)), 
            'date' => $this->date,
            'place' => $this->place, 
            'description' => $this->description, 
            'quantity' => $this->quantity, 
            'sold' => $this->sold, 
            'available' => ($this->quantity - $this->sold), 
            'tickets' => Tickets::collection($this->whenLoaded('tickets'))
        ];
    }
}
