<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\IRouteService;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use Throwable;

class RouteController extends Controller
{
    public function __construct(
        private readonly IRouteService $routeService
    ) {}

    /**
     * @param CreateRouteRequest $createRouteRequest
     * @return RouteResource
     * @throws ApiException
     */
    public function createRoute(CreateRouteRequest $createRouteRequest): RouteResource
    {
        try {
            $createRouteDto = CreateRouteDto::fromRequest($createRouteRequest);
            return RouteResource::make(
              $this->routeService->createRoute($createRouteDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }

    /**
     * @param int $routeId
     * @return RouteResource
     * @throws ApiException
     */
    public function getRoute(int $routeId): RouteResource
    {
        try {
            return RouteResource::make(
              $this->routeService->getRouteById($routeId)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }
}
