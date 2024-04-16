<?php

namespace App\Application\Contracts\In\Services\Place\Filter;

use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;

interface IPlaceFilterService
{
    /**
     * @return PlaceFilterDto
     */
    public function getFilters(): PlaceFilterDto;
}
