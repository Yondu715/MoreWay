<?php

namespace App\Models\Filters\Place;

class PlaceFilterFactory
{

    /**
     * @param array $filters
     * @return PlaceFilter
     */
    public function create(array $filters): PlaceFilter
    {
        return new PlaceFilter($filters);
    }
}
