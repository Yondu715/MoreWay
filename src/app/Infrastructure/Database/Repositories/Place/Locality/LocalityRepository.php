<?php

namespace App\Infrastructure\Database\Repositories\Place\Locality;

use App\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Infrastructure\Database\Models\Locality;
use App\Utils\Mappers\Out\Place\Locality\LocalityDtoMapper;
use Illuminate\Support\Collection;

class LocalityRepository implements ILocalityRepository
{
    /**
     * @return Collection<int, LocalityDto>
     */
    public function getAll(): Collection
    {
        $localities = Locality::all();
        return $localities->map(function (Locality $locality) {
            return LocalityDtoMapper::fromLocalityModel($locality);
        });
    }
}
