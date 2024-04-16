<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\GetPlaceDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\GetPlacesDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Place\PlaceNotFound;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\Place;
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
