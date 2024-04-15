<?php

namespace App\Infrastructure\Database\Repositories\Place\Locality;

use App\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Infrastructure\Database\Models\Locality;
use Illuminate\Support\Collection;

class LocalityRepository implements ILocalityRepository
{
    /**
     * @return Collection<int, Locality>
     */
    public function all(): Collection
    {
        return Locality::query()->get();
    }
}
