<?php

namespace App\Infrastructure\Http\Resources\Place\Filter;

use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;
use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Infrastructure\Database\Repositories\Place\Type\TypeRepository;
use App\Infrastructure\Http\Resources\Place\Locality\LocalityResource;
use App\Infrastructure\Http\Resources\Place\Type\TypeResource;
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
            'localities' => $this->localities->map(function ($locality) {
                return LocalityResource::make($locality);
            }),
            'types' => $this->types->map(function ($type) {
                return TypeResource::make($type);
            }),
            'minDistance' => $this->minDistance,
            'maxDistance' => $this->maxDistance
        ];
    }
}
