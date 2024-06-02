<?php

namespace App\Application\Services\Place;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Route\Point\PointDto;
use App\Application\DTO\Out\Place\ExtendedPlaceDto;
use App\Domain\Factories\Distance\DistanceManagerFactory;
use App\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Application\Contracts\In\Services\Place\IPlaceService;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Place\IPlaceRepository;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;

class PlaceService implements IPlaceService
{
    private readonly IDistanceManager $distanceManager;

    public function __construct(
        private readonly IPlaceRepository $placeRepository,
        private readonly IRouteConstructorRepository $routeConstructorRepository,
        private readonly ITokenManager $tokenManager
    ) {
        $this->distanceManager = DistanceManagerFactory::createInstance();
    }

    /**
     * @param GetPlaceDto $getPlaceDto
     * @return ExtendedPlaceDto
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): ExtendedPlaceDto
    {
        $distanceCalc = function (float $lat, float $lon) use ($getPlaceDto) {
            return $this->distanceManager->calculate($lat, $lon, $getPlaceDto->lat, $getPlaceDto->lon);
        };

        $constructor = $this->routeConstructorRepository->findByUserId($this->tokenManager->getAuthUser()->user->id, $distanceCalc);
        $place = $this->placeRepository->findById($getPlaceDto->placeId, $distanceCalc);

        $isInConstructor = (bool) $constructor->points->first(fn (PointDto $pointDto) => $pointDto->place->id === $place->id);

        return new ExtendedPlaceDto(
            place: $place,
            isInConstructor: $isInConstructor
        );
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
