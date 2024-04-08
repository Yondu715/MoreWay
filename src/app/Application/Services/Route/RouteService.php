<?php

namespace App\Application\Services\Route;

use App\Application\Contracts\In\Services\IRouteService;
use App\Application\Contracts\Out\Repositories\IRouteRepository;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\Exceptions\Route\FailedToCreateRoute;

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
        return RouteDto::fromRouteModel($route);
    }
}
