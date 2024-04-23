<?php

namespace App\Infrastructure\Database\Models\Filters\Place;

use Closure;

class PlaceFilterFactory
{
    /**
     * @param array $filters
     * @param Closure $distanceCalculator
     * @return PlaceFilter
     */
    public function create(array $filters, Closure $distanceCalculator): PlaceFilter
    {
        return new PlaceFilter($filters, $distanceCalculator);
    }
}
