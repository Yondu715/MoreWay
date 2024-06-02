<?php

namespace App\Application\Services\Route\Constructor;

use Throwable;
use App\Application\Enums\Route\RouteRestriction;
use App\Application\Exceptions\Route\ExceededCountItems;
use App\Domain\Factories\Distance\DistanceManagerFactory;
use App\Domain\Contracts\In\DomainManagers\IDistanceManager;
use App\Application\DTO\Out\Route\Constructor\RouteConstructorDto;
use App\Application\DTO\In\Route\Constructor\GetUserRouteConstructorDto;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Application\DTO\In\Route\Constructor\ChangeUserRouteConstructorDto;
use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\Out\Repositories\Route\Constructor\IRouteConstructorRepository;


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
        if (
            count($changeUserRouteConstructorDto->routePoints) < RouteRestriction::MIN_ROUTE_ITEMS->value ||
            count($changeUserRouteConstructorDto->routePoints) > RouteRestriction::MAX_ROUTE_ITEMS->value
        ) {
            throw new ExceededCountItems();
        }

        $distanceCalc = function (float $lat, float $lon) use ($changeUserRouteConstructorDto) {
            return $this->distanceManager->calculate($lat, $lon, $changeUserRouteConstructorDto->lat,
                $changeUserRouteConstructorDto->lon);
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
            return $this->distanceManager->calculate($lat, $lon, $getUserRouteConstructorDto->lat,
                $getUserRouteConstructorDto->lon);
        };
        return $this->routeConstructorRepository->findByUserId($getUserRouteConstructorDto->userId, $distanceCalc);
    }
}
