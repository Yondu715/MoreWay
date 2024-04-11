<?php

namespace App\Infrastructure\Database\Repositories\Place\Type;

use App\Application\Contracts\Out\Repositories\IPlaceTypeRepository;
use App\Infrastructure\Database\Models\PlaceType;
use Illuminate\Support\Collection;

class PlaceTypeRepository implements IPlaceTypeRepository
{
    /**
     * @return Collection<int, PlaceType>
     */
    public function all(): Collection
    {
        return PlaceType::query()->get();
    }
}
