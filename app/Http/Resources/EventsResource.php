<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Events;

class EventsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
          'event_name' => $this->event_name,
          'event_location' => $this->event_location,
          'event_start_date' => $this->event_start_date,
          'event_end_date' => $this->event_end_date,
          'event_price' => $this->event_price,
          'event_performances' => $this->event_performances,
          'image_url' => $this->image_url,
          'event_categories' => $this->event_categories,
          'event_contact_info' => $this->event_contact_info,
          'event_tickets_url' => $this->event_tickets_url,
     ];
    }
}
