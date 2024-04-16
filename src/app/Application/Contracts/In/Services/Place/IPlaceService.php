<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\GetPlaceDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\GetPlacesDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Place\PlaceDto;

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
