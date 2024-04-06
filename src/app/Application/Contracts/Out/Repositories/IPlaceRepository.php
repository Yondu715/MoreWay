<?php

namespace App\Application\Contracts\Out\Repositories;

use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\Exceptions\Place\PlaceNotFound;
use App\Infrastructure\Database\Models\Place;
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
