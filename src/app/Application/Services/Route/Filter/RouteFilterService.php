<?php

namespace App\Application\Services\Route\Filter;

use App\Application\DTO\Out\Route\Filter\RouteFilterDto;
use App\Application\Contracts\In\Services\Route\Filter\IRouteFilterService;

class RouteFilterService implements IRouteFilterService
{
    /**
     * @return RouteFilterDto
     */
    public function getFilters(): RouteFilterDto
    {
        return new RouteFilterDto(
            minPassing: 0,
            maxPassing: 700,
            minPoint: 2,
            maxPoint: 15
        );
    }
}
