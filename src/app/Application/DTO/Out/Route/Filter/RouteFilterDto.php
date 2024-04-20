<?php

namespace App\Application\DTO\Out\Route\Filter;

class RouteFilterDto
{
    public readonly int $minPassing;
    public readonly int $maxPassing;
    public readonly int $minPoint;
    public readonly int $maxPoint;


    public function __construct(
        int $minPassing,
        int $maxPassing,
        int $minPoint,
        int $maxPoint
    ) {
        $this->minPassing = $minPassing;
        $this->maxPassing = $maxPassing;
        $this->minPoint = $minPoint;
        $this->maxPoint = $maxPoint;
    }
}

