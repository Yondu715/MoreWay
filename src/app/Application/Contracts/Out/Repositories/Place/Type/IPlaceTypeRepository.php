<?php

namespace App\Application\Contracts\Out\Repositories\Place\Type;

use App\Application\DTO\Out\Place\Type\PlaceTypeDto;
use Illuminate\Support\Collection;

interface IPlaceTypeRepository
{
    /**
     * @return Collection<int, PlaceTypeDto>
     */
    public function getAll(): Collection;
}
