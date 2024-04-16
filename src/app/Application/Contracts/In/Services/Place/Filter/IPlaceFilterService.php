<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\Filter;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Place\Filter\PlaceFilterDto;

interface IPlaceFilterService
{
    /**
     * @return PlaceFilterDto
     */
    public function getFilters(): PlaceFilterDto;
}
