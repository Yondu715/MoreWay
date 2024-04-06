<?php

namespace App\Application\Contracts\In\Services;

use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;
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
     * @return array{data:array<PlaceDto>, next_cursor:string}
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): array;
}
