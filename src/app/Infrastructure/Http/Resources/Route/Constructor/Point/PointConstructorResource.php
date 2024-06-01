<?php

namespace App\Infrastructure\Http\Resources\Route\Constructor\Point;

use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Http\Resources\Place\ShortPlaceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin PointDto
 */
class PointConstructorResource extends JsonResource
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
            'place' => ShortPlaceResource::make($this->place)
        ];
    }
}
