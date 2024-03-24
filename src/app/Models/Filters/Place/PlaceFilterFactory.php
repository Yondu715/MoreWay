<?php

namespace App\Models\Filters\Place;

use Illuminate\Contracts\Container\BindingResolutionException;

class PlaceFilterFactory
{
    /**
     * @throws BindingResolutionException
     */
    public function create(array $filters): PlaceFilter
    {
        return app()->make(PlaceFilter::class, ['filters' => array_filter($filters)]);
    }
}
