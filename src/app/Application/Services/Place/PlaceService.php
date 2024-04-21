<?php

namespace App\Application\Services\Place;

use App\Application\Contracts\In\Services\Place\IPlaceService;
use App\Application\Contracts\Out\Repositories\Place\IPlaceRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Application\Exceptions\Place\PlaceNotFound;
use App\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Domain\Factories\Distance\DistanceManagerFactory;

class PlaceService implements IPlaceService
{
    private readonly IDistanceManager $distanceManager;

    public function __construct(
        private readonly IPlaceRepository $placeRepository,
    ) {
        $this->distanceManager = DistanceManagerFactory::createInstance();
    }

    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     * @throws PlaceNotFound
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto
    {
        $distanceCalc = function (float $lat, float $lon) use ($getPlaceDto) {
            return $this->distanceManager->calculate($lat, $lon, $getPlaceDto->lat, $getPlaceDto->lon);
        };
        return $this->placeRepository->getById($getPlaceDto, $distanceCalc);
    }

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return CursorDto
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): CursorDto
    {
        $distanceCalc = function (float $lat, float $lon) use ($getPlacesDto) {
                return $this->distanceManager->calculate($lat, $lon, $getPlacesDto->lat, $getPlacesDto->lon);
        };

        return $this->placeRepository->getAll($getPlacesDto, $distanceCalc);
    }
}
