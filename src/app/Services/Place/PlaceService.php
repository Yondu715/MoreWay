<?php

namespace App\Services\Place;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\Out\Place\PlaceDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Repositories\Place\Interfaces\IPlaceRepository;
use App\Services\Place\Interfaces\IPlaceService;
use Illuminate\Contracts\Pagination\CursorPaginator;

class PlaceService implements IPlaceService
{
    public function __construct(
        private readonly IPlaceRepository $placeRepository
    ) {
    }

    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     * @throws PlaceNotFound
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto
    {
        $place = $this->placeRepository->getPlaceById($getPlaceDto);

        $rating = round($place->reviews()->avg('rating'), 2);

        return PlaceDto::fromPlaceModel($place, $rating);
    }

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorPaginator
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorPaginator
    {
        $places = $this->placeRepository->getPlaces($getPlacesDto);

        foreach ($places as $place) {
            $place->rating = round($place->reviews()->avg('rating'), 2);
        }
        return $places;
    }
}
