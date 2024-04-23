<?php

namespace App\Infrastructure\Database\Repositories\Place\Type;

use App\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Application\DTO\Out\Place\Type\PlaceTypeDto;
use App\Infrastructure\Database\Models\PlaceType;
use App\Utils\Mappers\Out\Place\Type\PlaceTypeDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PlaceTypeRepository implements IPlaceTypeRepository
{
    private readonly Model $model;

    public function __construct(PlaceType $placeType)
    {
        $this->model = $placeType;
    }

    /**
     * @return Collection<int, PlaceTypeDto>
     */
    public function getAll(): Collection
    {
        $types = $this->model->all();
        return $types->map(function (PlaceType $placeType) {
            return PlaceTypeDtoMapper::fromTypeModel($placeType);
        });
    }
}
