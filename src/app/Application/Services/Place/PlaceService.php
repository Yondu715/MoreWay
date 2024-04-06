<?php

namespace App\Application\Services\Place;

use App\Application\Contracts\In\Services\IPlaceService;
use App\Application\Contracts\Out\Repositories\IPlaceRepository;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Application\Exceptions\Place\PlaceNotFound;
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
