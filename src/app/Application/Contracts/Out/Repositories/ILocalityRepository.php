<?php

namespace App\Application\Contracts\Out\Repositories;

use App\Infrastructure\Database\Models\Locality;
use Illuminate\Support\Collection;

interface ILocalityRepository
{
    /**
     * @return Collection<int, Locality>
     */
    public function all(): Collection;
}
