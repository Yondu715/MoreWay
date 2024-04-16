<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Locality;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Locality;
use Illuminate\Support\Collection;

interface ILocalityRepository
{
    /**
     * @return Collection<int, Locality>
     */
    public function all(): Collection;
}
