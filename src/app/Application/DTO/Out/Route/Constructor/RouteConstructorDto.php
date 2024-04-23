<?php

namespace App\Application\DTO\Out\Route\Constructor;

use Illuminate\Support\Collection;

class RouteConstructorDto
{
    public readonly Collection $points;
    public readonly int $id;

    public function __construct(
        Collection $points,
        int $id
    ) {
        $this->points = $points;
        $this->id = $id;
    }
}
