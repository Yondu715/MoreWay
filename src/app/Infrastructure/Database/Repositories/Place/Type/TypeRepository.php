<?php

namespace App\Infrastructure\Database\Repositories\Place\Type;

use App\Application\Contracts\Out\Repositories\ITypeRepository;
use App\Infrastructure\Database\Models\PlaceType;
use Illuminate\Support\Collection;

class TypeRepository implements ITypeRepository
{
    /**
     * @return Collection<int, PlaceType>
     */
    public function all(): Collection
    {
        return PlaceType::query()->get();
    }
}
