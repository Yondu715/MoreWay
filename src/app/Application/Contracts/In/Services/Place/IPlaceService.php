<?php

namespace App\Application\Contracts\In\Services\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;

interface IPlaceService
{
    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto;

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorDto
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorDto;
}
