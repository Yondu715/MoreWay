<?php

namespace App\Application\Contracts\Out\Repositories;

use App\Infrastructure\Database\Models\PlaceType;
use Illuminate\Support\Collection;

interface IPlaceTypeRepository
{
    /**
     * @return Collection<int, PlaceType>
     */
    public function all(): Collection;
}
