<?php

namespace App\Http\Resources\Place;

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
            'data' => $this->collection->map(function ($resource) {
                return [
                    'distance' => $resource->distance,
                    'id' => $resource->id,
                    'name' => $resource->name,
                    'lat' => $resource->lat,
                    'lon' => $resource->lon,
                    'rating' => $resource->rating,
                    'image' => count($resource->images) ? [
                        'id' => $resource->images[0]->id,
                        'path' => $resource->images[0]->image
                    ] : null,
                    'locality' => $resource->locality
                ];
            })
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function paginationInformation(Request $request): array
    {
        $paginated = $this->resource->toArray();

        return [
            'meta' => [
                'next_cursor' => $paginated['next_cursor']
            ]
        ];
    }
}
