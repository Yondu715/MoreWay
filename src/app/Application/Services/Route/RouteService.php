<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Route;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\IRouteService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Route\IRouteRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Route\RouteDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route\FailedToCreateRoute;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route\RouteNotFound;

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

    /**
     * @param int $routeId
     * @return RouteDto
     * @throws RouteNotFound
     */
    public function getRouteById(int $routeId): RouteDto
    {
        $route = $this->routeRepository->findById($routeId);
        return RouteDto::fromRouteModel($route);
    }
}
