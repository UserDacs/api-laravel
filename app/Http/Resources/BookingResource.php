<?php


namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'id' => $this->id,
            'tracking_number' => $this->tracking_number,
            'booking_date' => $this->booking_date,
            'booking_details' => $this->booking_details,
            'booking_location' => $this->booking_location,
            'payment_method' => $this->payment_method,
            'total_price' => $this->total_price,
            'service' => $this->service,
            'user' => $this->user,
            'owner' => $this->owner,
        ];
    }
}