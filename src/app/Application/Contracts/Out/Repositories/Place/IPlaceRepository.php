<?php

namespace App\Application\Contracts\Out\Repositories\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;
use Closure;

interface IPlaceRepository
{

    /**
     * @param GetPlaceDto $getPlaceDto
     * @param Closure $distanceCalculator
     * @return PlaceDto
     */
    public function getById(GetPlaceDto $getPlaceDto, Closure $distanceCalculator): PlaceDto;

    /**
     * @param GetPlacesDto $getPlacesDto
     * @param Closure $distanceCalculator
     * @return CursorDto
     */
    public function getAll(GetPlacesDto $getPlacesDto, Closure $distanceCalculator): CursorDto;
}
