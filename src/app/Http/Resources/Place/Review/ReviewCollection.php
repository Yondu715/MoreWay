<?php

namespace App\Http\Resources\Place\Review;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->resource,
            'meta' => [
                'next_cursor' => $this->collection,
            ]
        ];
    }
}
