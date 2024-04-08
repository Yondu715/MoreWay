<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\IRouteService;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use Exception;

class RouteController extends Controller
{
    public function __construct(
        private readonly IRouteService $routeService
    ) {}

    /**
     * @param CreateRouteRequest $createRouteRequest
     * @return RouteResource
     * @throws Exception
     */
    public function createRoute(CreateRouteRequest $createRouteRequest): RouteResource
    {
        try {
            $createRouteDto = CreateRouteDto::fromRequest($createRouteRequest);
            return RouteResource::make(
              $this->routeService->createRoute($createRouteDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
