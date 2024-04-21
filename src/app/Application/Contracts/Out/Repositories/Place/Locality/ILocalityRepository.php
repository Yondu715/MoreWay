<?php

namespace App\Application\Contracts\Out\Repositories\Place\Locality;

use App\Application\DTO\Out\Place\Locality\LocalityDto;
use Illuminate\Support\Collection;

interface ILocalityRepository
{
    /**
     * @return Collection<int, LocalityDto>
     */
    public function getAll(): Collection;
}
