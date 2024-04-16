<?php

namespace App\Infrastructure\Http\Resources\Place\Filter;

use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin PlaceFilterDto
 */
class PlaceFilterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'localities' => $this->localities,
            'types' => $this->types,
            'minDistance' => $this->minDistance,
            'maxDistance' => $this->maxDistance
        ];
    }
}
