<?php

namespace App\Services\Place\Interfaces;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\Out\Place\PlaceDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceService
{
    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto;

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorPaginator
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorPaginator;
}
