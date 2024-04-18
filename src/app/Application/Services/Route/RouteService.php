<?php

namespace App\Application\Services\Route;

use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;

class RouteService implements IRouteService
{
    public function __construct(
        private readonly IRouteRepository $routeRepository
    ) {}

    /**
     * @param CreateRouteDto $createRouteDto
     * @return RouteDto
     * @throws FailedToCreateRoute
     */
    public function createRoute(CreateRouteDto $createRouteDto): RouteDto
    {
        $route = $this->routeRepository->create($createRouteDto);
        return RouteDtoMapper::fromRouteModel($route);
    }

    /**
     * @param int $routeId
     * @return RouteDto
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId): RouteDto
    {
        $route = $this->routeRepository->findById($routeId);
        return RouteDtoMapper::fromRouteModel($route);
    }
}
