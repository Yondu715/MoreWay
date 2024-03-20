<?php

namespace App\Services\Place;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\Out\Place\PlaceDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Filters\Place\PlaceFilter;
use App\Lib\Distance\DistanceManager;
use App\Lib\Rating\RatingManager;
use App\Models\Place;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\CursorPaginator;

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

        foreach ($place->images->all() as $image) {
            unset($image->place_id);
        }

        $distance = DistanceManager::calc($getPlaceDto->lat, $getPlaceDto->lon, $place->lat, $place->lon);
        $rating = RatingManager::calc($place);

        return PlaceDto::fromPlaceModel($place, $distance, $rating);
    }

    /**
     * @throws BindingResolutionException
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorPaginator
    {
        $filter = app()->make(PlaceFilter::class, ['queryParams' => array_filter(['locality_id' => 2])]);

        $places = Place::filter($filter)
            ->cursorPaginate(perPage: 2, cursor: $getPlacesDto->cursor);

        foreach ($places as $place){

            foreach ($place->images->all() as $image) {
                unset($image->place_id);
            }

            $place->distance = DistanceManager::calc($getPlacesDto->lat, $getPlacesDto->lon, $place->lat, $place->lon);
            $place->rating = RatingManager::calc($place);
        }

        return $places;
    }
}
