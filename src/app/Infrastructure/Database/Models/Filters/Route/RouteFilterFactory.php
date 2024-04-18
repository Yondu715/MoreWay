<?php

namespace App\Infrastructure\Database\Models\Filters\Route;

class RouteFilterFactory
{
    /**
     * @param array $filters
     * @return RouteFilter
     */
    public function create(array $filters): RouteFilter
    {
        return new RouteFilter($filters);
    }
}

