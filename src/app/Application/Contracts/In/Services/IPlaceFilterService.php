<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;

interface IPlaceFilterService
{
    /**
     * @return PlaceFilterDto
     */
    public function getFilters(): PlaceFilterDto;
}
