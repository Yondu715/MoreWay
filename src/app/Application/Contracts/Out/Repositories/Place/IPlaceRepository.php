<?php

namespace App\Application\Contracts\Out\Repositories\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;
use Closure;

interface IPlaceRepository
{

    /**
     * @param int $placeId
     * @param Closure $distanceCalculator
     * @return PlaceDto
     */
    public function findById(int $placeId, Closure $distanceCalculator): PlaceDto;

    /**
     * @param GetPlacesDto $getPlacesDto
     * @param Closure $distanceCalculator
     * @return CursorDto
     */
    public function getAll(GetPlacesDto $getPlacesDto, Closure $distanceCalculator): CursorDto;
}
