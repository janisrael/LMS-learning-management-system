<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeEventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $result = [
            'customer' => [
                "email" => $request->email
            ],
            'event_type_id' => $request->event_type_id,
            'date' => $request->date,
            'region' => $request->region
        ];

        return $result;
    }
}
