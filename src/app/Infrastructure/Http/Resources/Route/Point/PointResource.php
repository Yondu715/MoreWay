<?php

namespace App\Infrastructure\Http\Resources\Route\Point;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTO\Out\Route\Point\PointDto;
use App\Infrastructure\Http\Resources\Place\ShortPlaceResource;

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
            'isCompleted' => $this->when($this->isCompleted !== null, $this->isCompleted, null),
            'place' => ShortPlaceResource::make($this->place)
        ];
    }
}
