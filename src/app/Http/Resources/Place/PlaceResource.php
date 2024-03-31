<?php

namespace App\Http\Resources\Place;

use App\Models\Place;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Place
 * @property float $rating
 * @property float $distance
 */
class PlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'distance' => $this->distance,
            'id' => $this->id,
            'name' => $this->name,
            'lat' => $this->lat,
            'lon' => $this->lon,
            'rating' => $this->rating,
            'description' => $this->description,
            'images' => 'https://more-way.ru/storage/'.$this->images,
            'locality' => $this->locality
        ];
    }
}
