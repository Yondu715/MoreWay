<?php

namespace App\Infrastructure\Http\Resources\Route\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Http\Resources\Place\Image\ImageResource;
use App\Infrastructure\Http\Resources\Place\Locality\LocalityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PointDto
 */
class PointResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'index' => $this->index,
            'place' => [
                'id' => $this->place->id,
                'name' => $this->place->name,
                'lat' => $this->place->lat,
                'lon' => $this->place->lon,
                'rating' => $this->place->rating,
                'images' => $this->place->images->map(function ($image) {
                    return ImageResource::make($image);
                }),
                'locality' => LocalityResource::make($this->place->locality)
            ]
        ];
    }
}
