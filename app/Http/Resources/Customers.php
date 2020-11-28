<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Customers extends JsonResource
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
            'document' => $this->document, 
            'birth_day' => $this->birth_day, 
            'email' => $this->email, 
            'phone' => $this->phone,
            'tickets' => $this->whenLoaded('tickets')
        ];
    }


}
