<?php

namespace App\Infrastructure\Database\Repositories\Place\Locality;

use App\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Infrastructure\Database\Models\Locality;
use App\Utils\Mappers\Out\Place\Locality\LocalityDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class LocalityRepository implements ILocalityRepository
{
    private readonly Model $model;

    public function __construct(Locality $locality)
    {
        $this->model = $locality;
    }

    /**
     * @return Collection<int, LocalityDto>
     */
    public function getAll(): Collection
    {
        $localities = $this->model->all();
        return $localities->map(function (Locality $locality) {
            return LocalityDtoMapper::fromLocalityModel($locality);
        });
    }
}
