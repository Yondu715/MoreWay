<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\In\Services\Route\Filter\IRouteFilterService;
use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Application\Exceptions\Filter\FilterOutOfRange;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;
use App\Infrastructure\Http\Requests\Route\CompletedRoutePointRequest;
use App\Infrastructure\Http\Requests\Route\Constructor\ChangeUserRouteConstructorRequest;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Infrastructure\Http\Requests\Route\GetRoutesRequest;
use App\Infrastructure\Http\Requests\Route\GetUserRoutesRequest;
use App\Infrastructure\Http\Resources\Review\ReviewCursorResource;
use App\Infrastructure\Http\Resources\Review\ReviewResource;
use App\Infrastructure\Http\Resources\Route\Constructor\ConstructorResource;
use App\Infrastructure\Http\Resources\Route\Filter\RouteFilterResource;
use App\Infrastructure\Http\Resources\Route\RouteCursorResource;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use App\Infrastructure\Http\Resources\Route\UserActiveRouteResource;
use App\Utils\Mappers\In\Route\CompletedRoutePointDtoMapper;
use App\Utils\Mappers\In\Route\Constructor\ConstructorDtoMapper;
use App\Utils\Mappers\In\Route\CreateRouteDtoMapper;
use App\Utils\Mappers\In\Route\GetRoutesDtoMapper;
use App\Utils\Mappers\In\Route\GetUserRoutesDtoMapper;
use App\Utils\Mappers\In\Route\Review\GetRouteReviewsDtoMapper;
use App\Utils\Mappers\In\Route\Review\CreateRouteReviewDtoMapper;
use Throwable;

class RouteController extends Controller
{
    public function __construct(
        private readonly IRouteService $routeService,
        private readonly IRouteReviewService $reviewService,
        private readonly IRouteFilterService $filterService,
        private readonly IRouteConstructorService $constructorService,
    ) {
    }

    /**
     * @param CreateRouteRequest $createRouteRequest
     * @return RouteResource
     * @throws ApiException
     */
    public function createRoute(CreateRouteRequest $createRouteRequest): RouteResource
    {
        try {
            $createRouteDto = CreateRouteDtoMapper::fromRequest($createRouteRequest);
            return RouteResource::make(
                $this->routeService->createRoute($createRouteDto)
            );
        } catch (FailedToCreateRoute $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
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
        } catch (RouteNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetRoutesRequest $getRoutesRequest
     * @return RouteCursorResource
     * @throws ApiException
     */
    public function getRoutes(GetRoutesRequest $getRoutesRequest): RouteCursorResource
    {
        try {
            $getRoutesDto = GetRoutesDtoMapper::fromRequest($getRoutesRequest);
            return RouteCursorResource::make(
                $this->routeService->getRoutes($getRoutesDto)
            );
        } catch (RouteNotFound|FilterOutOfRange $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return ReviewResource
     */
    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        $createReviewDto = CreateRouteReviewDtoMapper::fromRequest($createReviewRequest);
        return ReviewResource::make(
            $this->reviewService->createReviews($createReviewDto)
        );
    }

    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return ReviewCursorResource
     */
    public function getReviews(GetReviewsRequest $getReviewsRequest): ReviewCursorResource
    {
        $getReviewsDto = GetRouteReviewsDtoMapper::fromRequest($getReviewsRequest);
        return ReviewCursorResource::make(
            $this->reviewService->getReviews($getReviewsDto)
        );
    }

    /**
     * @return RouteFilterResource
     */
    public function getFilters(): RouteFilterResource
    {
        return RouteFilterResource::make(
            $this->filterService->getFilters()
        );
    }

    /**
     * @param ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest
     * @return ConstructorResource
     * @throws ApiException
     */
    public function changeUserRouteConstructor(ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest): ConstructorResource
    {
        try {
            $changeUserRouteConstructorDto = ConstructorDtoMapper::fromRequest($changeUserRouteConstructorRequest);
            return ConstructorResource::make(
                $this->constructorService->change($changeUserRouteConstructorDto)
            );
        } catch (InvalidRoutePointIndex|Throwable $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $userId
     * @return ConstructorResource
     */
    public function getUserRouteConstructor(int $userId): ConstructorResource
    {
        return ConstructorResource::make(
            $this->constructorService->get($userId)
        );
    }

    /**
     * @param CompletedRoutePointRequest $completedRoutePointRequest
     * @return void
     * @throws ApiException
     */
    public function completedRoutePoint(CompletedRoutePointRequest $completedRoutePointRequest): void
    {
        try {
            $completedRoutePointDto = CompletedRoutePointDtoMapper::fromRequest($completedRoutePointRequest);
            $this->routeService->completedRoutePoint($completedRoutePointDto);
        } catch (RouteNotFound|IncorrectOrderRoutePoints|UserRouteProgressNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetUserRoutesRequest $getUserRoutesRequest
     * @return RouteCursorResource
     */
    public function getUsersRoutes(GetUserRoutesRequest $getUserRoutesRequest): RouteCursorResource
    {
        $getUserRoutesDto = GetUserRoutesDtoMapper::fromRequest($getUserRoutesRequest);
        return RouteCursorResource::make(
            $this->routeService->getUsersRoutes($getUserRoutesDto)
        );
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return void
     * @throws ApiException
     */
    public function deleteUserRoute(int $userId, int $routeId): void
    {
        try {
            $this->routeService->deleteUserRoute($userId, $routeId);
        } catch (RouteNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $userId
     * @return UserActiveRouteResource
     * @throws ApiException
     */
    public function getActiveUserRoute(int $userId): UserActiveRouteResource
    {
        try {
            return UserActiveRouteResource::make(
                $this->routeService->getActiveUserRoute($userId)
            );
        } catch (UserHaveNotActiveRoute $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
