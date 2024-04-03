<?php

namespace App\Repositories\Place\Interfaces;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Models\Place;
use Illuminate\Contracts\Pagination\CursorPaginator;

interface IPlaceRepository
{
    /**
     * @param GetPlaceDto $getPlaceDto
     * @return Place
     * @throws PlaceNotFound
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): Place;

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorPaginator
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorPaginator;
}
