<?php

namespace App\Utils\Mappers\Out\Place\Type;

use App\Application\DTO\Out\Place\Type\PlaceTypeDto;
use App\Infrastructure\Database\Models\PlaceType;
use Illuminate\Support\Collection;

class PlaceTypeDtoMapper
{
    /**
     * @param PlaceType $placeType
     * @return PlaceTypeDto
     */
    public static function fromTypeModel(PlaceType $placeType): PlaceTypeDto
    {
        return new PlaceTypeDto(
            id: $placeType->id,
            name: $placeType->name,
        );
    }

    /**
     * @param Collection<int, PlaceType> $types
     * @return Collection<int, string>
     */
    public static function fromTypeCollection(Collection $types): Collection
    {
        return $types->map(function (PlaceTypeDto $type) {
            return $type->name;
        });
    }
}