<?php

namespace App\Http\Resources\Place;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PlaceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
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
