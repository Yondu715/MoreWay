<?php

namespace App\Application\Services\Place;

use App\Application\Contracts\In\DomainManagers\IDistanceManager;
use App\Application\Contracts\In\Services\IPlaceService;
use App\Application\Contracts\Out\Repositories\IPlaceRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceCursorDto;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Application\Exceptions\Place\PlaceNotFound;

class PlaceService implements IPlaceService
{
    public function __construct(
        private readonly IPlaceRepository $placeRepository,
        private readonly IDistanceManager $distanceManager
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
        return PlaceDto::fromPlaceModel($place, $this->distanceManager
            ->calculate(
            $place->lat,
            $place->lon,
            $getPlaceDto->lat,
            $getPlaceDto->lon
        ));
    }

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorDto
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorDto
    {
        $places = $this->placeRepository->getPlaces($getPlacesDto);

        return PlaceCursorDto::fromPaginator(collect($places->items())->map(function ($place) use ($getPlacesDto){
            return PlaceDto::fromPlaceModel($place, $this->distanceManager
                ->calculate(
                    $place->lat,
                    $place->lon,
                    $getPlacesDto->lat,
                    $getPlacesDto->lon
                ));
        }), $places->nextCursor() ? $places->nextCursor()->encode() : null);
    }
}
