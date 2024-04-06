<?php

namespace App\Infrastructure\Http\Resources\Place;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaceCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this['data']->map(function ($resource) {
                return [
                    'distance' => $resource->distance,
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'lat' => $resource->lat,
                    'lon' => $resource->lon,
                    'rating' => $resource->rating,
                    'image' => count($resource->images) ? [
                        'id' => $resource->images[0]->id,
                        'path' => 'https://more-way.ru/storage/' . $resource->images[0]->image
                    ] : null,
                    'locality' => $resource->locality
                ];
            }),
            'meta' => [
                'next_cursor' => $this['next_cursor']->resource
            ]
        ];
    }
}
