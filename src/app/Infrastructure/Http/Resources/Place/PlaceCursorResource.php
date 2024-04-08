<?php

namespace App\Infrastructure\Http\Resources\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Http\Resources\Place\Image\ImageResource;
use App\Infrastructure\Http\Resources\Place\Locality\LocalityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CursorDto
 */
class PlaceCursorResource extends JsonResource
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->data->map(function ($resource) {
                return [
                    'distance' => $resource->distance,
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'lat' => $resource->lat,
                    'lon' => $resource->lon,
                    'rating' => $resource->rating,
                    'image' => count($resource->images) ? ImageResource::make($resource->images[0]) : null,
                    'locality' => LocalityResource::make($resource->locality)
                ];
            }),
            'meta' => [
                'next_cursor' => $this->next_cursor
            ]
        ];
    }
}
