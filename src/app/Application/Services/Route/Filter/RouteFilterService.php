<?php

namespace App\Application\Services\Route\Filter;

use App\Application\Contracts\In\Services\Route\Filter\IRouteFilterService;
use App\Application\DTO\Out\Route\Filter\RouteFilterDto;
use App\Utils\Mappers\Out\Route\Filter\RouteFilterDtoMapper;

class RouteFilterService implements IRouteFilterService
{
    /**
     * @return RouteFilterDto
     */
    public function getFilters(): RouteFilterDto
    {
        return RouteFilterDtoMapper::fromFilters([
            'minPassing' => 0,
            'maxPassing' => 700,
            'minPoint' => 2,
            'maxPoint' => 20,
        ]);
    }
}
