<?php

namespace App\Services\Place;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\Out\Place\PlaceDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Lib\Distance\DistanceManager;
use App\Lib\Rating\RatingManager;
use App\Models\Place;

class PlaceService
{
    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     * @throws PlaceNotFound
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto
    {
        /** @var ?Place $place */
        $place = Place::query()->find($getPlaceDto->id);

        if (!$place) {
            throw new PlaceNotFound();
        }

        $distance = DistanceManager::calc($getPlaceDto->lat, $getPlaceDto->lon, $place->lat, $place->lon);

        $rating = RatingManager::calc($place);

        return PlaceDto::fromPlaceModel($place, $distance, $rating);
    }
}
