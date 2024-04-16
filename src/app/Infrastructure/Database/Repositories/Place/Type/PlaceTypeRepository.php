<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Repositories\Place\Type;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceType;
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
