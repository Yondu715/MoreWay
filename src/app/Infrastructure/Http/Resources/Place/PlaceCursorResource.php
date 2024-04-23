<?php

namespace App\Infrastructure\Http\Resources\Place;

use App\Application\DTO\Collection\CursorDto;
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
            'data' => ShortPlaceResource::collection($this->data),
            'meta' => [
                'next_cursor' => $this->next_cursor
            ]
        ];
    }
}
