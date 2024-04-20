<?php

namespace App\Application\Contracts\In\Services\Route\Filter;

use App\Application\DTO\Out\Route\Filter\RouteFilterDto;

interface IRouteFilterService
{
    /**
     * @return RouteFilterDto
     */
    public function getFilters(): RouteFilterDto;
}
