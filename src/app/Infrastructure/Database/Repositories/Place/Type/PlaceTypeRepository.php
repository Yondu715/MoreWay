<?php

namespace App\Infrastructure\Database\Repositories\Place\Type;

use App\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Infrastructure\Database\Models\PlaceType;
use App\Utils\Mappers\Out\Place\Type\PlaceTypeDtoMapper;
use Illuminate\Support\Collection;

class PlaceTypeRepository implements IPlaceTypeRepository
{
    /**
     * @return Collection<int, PlaceTypeDto>
     */
    public function getAll(): Collection
    {
        $types = PlaceType::all();
        return $types->map(function (PlaceType $placeType) {
            return PlaceTypeDtoMapper::fromTypeModel($placeType);
        });
    }
}
