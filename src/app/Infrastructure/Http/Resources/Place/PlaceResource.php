<?php

namespace App\Infrastructure\Http\Resources\Place;

use App\Infrastructure\Database\Models\Place;
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
            'images' => collect($this->images)->map(function ($resource) {
                return [
                    'id' => $resource->id,
                    'path' => $resource->image
                ];
            }),
            'locality' => LocalityResource::make($this->locality)
        ];
    }
}
