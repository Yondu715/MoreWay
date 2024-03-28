<?php

namespace App\Services\Place;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\Out\Place\PlaceDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Models\Filters\Place\PlaceFilter;
use App\Models\Filters\Place\PlaceFilterFactory;
use App\Models\Place;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Query\Builder;


class PlaceService
{
    public function __construct(
        private readonly PlaceFilterFactory $placeFilterFactory
    ){}

    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     * @throws PlaceNotFound
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto
    {
        /** @var ?Builder $place */
        $place = Place::query()
            ->where('id', $getPlaceDto->id);

        if (!$place) {
            throw new PlaceNotFound();
        }

        /** @var ?Place $place */
        $place = $place->select('places.*')
            ->selectRaw("ROUND(ST_Distance_Sphere(Point(places.lon, places.lat), Point(?, ?)) / 1000, 1) as distance",
                [$getPlaceDto->lon, $getPlaceDto->lat])
            ->first();

        foreach ($place->images->all() as $image) {
            unset($image->place_id);
        }

        $rating = round($place->reviews()->avg('rating'), 2);
        return PlaceDto::fromPlaceModel($place, $rating);
    }

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorPaginator
     * @throws BindingResolutionException
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorPaginator
    {
        $paramsRequest = ($getPlacesDto->cursor !== null && $getPlacesDto->filter['sort'] !== null && $getPlacesDto->filter['sort']['sort'] === 'distance')
            ? [$getPlacesDto->lon, $getPlacesDto->lat, $getPlacesDto->lon, $getPlacesDto->lat]
            : [$getPlacesDto->lon, $getPlacesDto->lat];

        $places = Place::query()
            ->select('places.*')
            ->selectRaw("ROUND(ST_Distance_Sphere(Point(places.lon, places.lat), Point(?, ?)) / 1000, 1) as distance",
                $paramsRequest)
            ->filter($this->placeFilterFactory->create($getPlacesDto->filter))
            ->cursorPaginate(perPage: 3, cursor: $getPlacesDto->cursor);

        foreach ($places as $place){
            foreach ($place->images->all() as $image) {
                unset($image->place_id);
            }
            $place->rating = round($place->reviews()->avg('rating'), 2);
        }
        return $places;
    }
}
