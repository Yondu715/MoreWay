<?php

namespace App\Application\DTO\Out\Route\Constructor;

use Illuminate\Support\Collection;

class RouteConstructorDto
{
    public readonly Collection $points;

    public function __construct(
        Collection $points
    ) {
        $this->points = $points;
    }
}
