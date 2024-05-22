<?php

namespace App\Application\Services\Route\Constructor;

use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;
use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Application\DTO\In\Route\Constructor\GetUserRouteConstructorDto;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Domain\Contracts\In\DomainManagers\IDistanceManager;use App\Domain\Factories\Distance\DistanceManagerFactory;use Throwable;

class RouteConstructorService implements IRouteConstructorService
{
    private readonly IDistanceManager $distanceManager;
    public function __construct(
        private readonly IRouteConstructorRepository $routeConstructorRepository
    ) {
        $this->distanceManager = DistanceManagerFactory::createInstance();
    }

    /**
     * @param ChangeUserRouteConstructorDto $changeUserRouteConstructorDto
     * @return RouteConstructorDto
     * @throws InvalidRoutePointIndex
     * @throws Throwable
     */
    public function change(ChangeUserRouteConstructorDto $changeUserRouteConstructorDto): RouteConstructorDto
    {
        $distanceCalc = function (float $lat, float $lon) use ($changeUserRouteConstructorDto) {
            return $this->distanceManager->calculate($lat, $lon, $changeUserRouteConstructorDto->lat, $changeUserRouteConstructorDto->lon);
        };
        return $this->routeConstructorRepository->update($changeUserRouteConstructorDto, $distanceCalc);
    }

    /**
     * @param GetUserRouteConstructorDto $getUserRouteConstructorDto
     * @return RouteConstructorDto
     */
    public function get(GetUserRouteConstructorDto $getUserRouteConstructorDto): RouteConstructorDto
    {
        $distanceCalc = function (float $lat, float $lon) use ($getUserRouteConstructorDto) {
            return $this->distanceManager->calculate($lat, $lon, $getUserRouteConstructorDto->lat, $getUserRouteConstructorDto->lon);
        };
        return $this->routeConstructorRepository->findByUserId($getUserRouteConstructorDto, $distanceCalc);
    }
}
