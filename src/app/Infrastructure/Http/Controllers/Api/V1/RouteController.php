<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Exceptions\Filter\FilterOutOfRange;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\IncorrectOrderRoutePoints;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Route\UserHaveNotActiveRoute;
use App\Application\Exceptions\Route\UserRouteProgressNotFound;
use Illuminate\Http\Response;
use App\Utils\Mappers\In\Route\GetRoutesDtoMapper;
use App\Infrastructure\Http\Controllers\Controller;
use App\Utils\Mappers\In\Route\CreateRouteDtoMapper;
use App\Utils\Mappers\In\Route\GetUserRoutesDtoMapper;
use App\Utils\Mappers\In\Route\ChangeUserRouteDtoMapper;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use App\Infrastructure\Http\Requests\Route\GetRoutesRequest;
use App\Infrastructure\Http\Resources\Review\ReviewResource;
use App\Utils\Mappers\In\Route\CompletedRoutePointDtoMapper;
use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Utils\Mappers\In\Route\Review\GetRouteReviewsDtoMapper;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;
use App\Infrastructure\Http\Requests\Route\GetUserRoutesRequest;
use App\Infrastructure\Http\Resources\Route\RouteCursorResource;
use App\Utils\Mappers\In\Route\Review\CreateRouteReviewDtoMapper;
use App\Infrastructure\Http\Requests\Route\ChangeUserRouteRequest;
use App\Infrastructure\Http\Resources\Review\ReviewCursorResource;
use App\Infrastructure\Http\Resources\Route\UserActiveRouteResource;
use App\Infrastructure\Http\Requests\Route\CompletedRoutePointRequest;
use App\Infrastructure\Http\Resources\Route\Filter\RouteFilterResource;
use App\Application\Contracts\In\Services\Route\Filter\IRouteFilterService;
use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Infrastructure\Http\Resources\Route\Constructor\ConstructorResource;
use App\Utils\Mappers\In\Route\Constructor\GetUserRouteConstructorDtoMapper;
use App\Utils\Mappers\In\Route\Constructor\ChangeUserRouteConstructorDtoMapper;
use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Infrastructure\Http\Requests\Route\Constructor\GetUserRouteConstructorRequest;
use App\Infrastructure\Http\Requests\Route\Constructor\ChangeUserRouteConstructorRequest;

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
     * @throws FailedToCreateRoute
     */
    public function createRoute(CreateRouteRequest $createRouteRequest): RouteResource
    {
        $createRouteDto = CreateRouteDtoMapper::fromRequest($createRouteRequest);
        return RouteResource::make(
            $this->routeService->createRoute($createRouteDto)
        );
    }

    /**
     * @param int $routeId
     * @return RouteResource
     */
    public function getRoute(int $routeId): RouteResource
    {
        return RouteResource::make(
            $this->routeService->getRouteById($routeId)
        );
    }

    /**
     * @param GetRoutesRequest $getRoutesRequest
     * @return RouteCursorResource
     * @throws FilterOutOfRange
     */
    public function getRoutes(GetRoutesRequest $getRoutesRequest): RouteCursorResource
    {
        $getRoutesDto = GetRoutesDtoMapper::fromRequest($getRoutesRequest);
        return RouteCursorResource::make(
            $this->routeService->getRoutes($getRoutesDto)
        );
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
     * @throws InvalidRoutePointIndex
     */
    public function changeUserRouteConstructor(ChangeUserRouteConstructorRequest $changeUserRouteConstructorRequest): ConstructorResource
    {
        $changeUserRouteConstructorDto = ChangeUserRouteConstructorDtoMapper::fromRequest($changeUserRouteConstructorRequest);
        return ConstructorResource::make(
            $this->constructorService->change($changeUserRouteConstructorDto)
        );
    }

    /**
     * @param GetUserRouteConstructorRequest $getUserRouteConstructorRequest
     * @return ConstructorResource
     */
    public function getUserRouteConstructor(GetUserRouteConstructorRequest $getUserRouteConstructorRequest): ConstructorResource
    {
        $getUserRouteConstructorDto = GetUserRouteConstructorDtoMapper::fromRequest($getUserRouteConstructorRequest);
        return ConstructorResource::make(
            $this->constructorService->get($getUserRouteConstructorDto)
        );
    }

    /**
     * @param CompletedRoutePointRequest $completedRoutePointRequest
     * @return Response
     * @throws IncorrectOrderRoutePoints
     * @throws UserRouteProgressNotFound
     */
    public function completedRoutePoint(CompletedRoutePointRequest $completedRoutePointRequest): Response
    {
        $completedRoutePointDto = CompletedRoutePointDtoMapper::fromRequest($completedRoutePointRequest);
        $this->routeService->completedRoutePoint($completedRoutePointDto);
        return response()->noContent();
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
     * @return Response
     */
    public function deleteUserRoute(int $userId, int $routeId): Response
    {
        $this->routeService->deleteUserRoute($userId, $routeId);
        return response()->noContent();
    }

    /**
     * @param int $userId
     * @return UserActiveRouteResource
     * @throws UserHaveNotActiveRoute
     */
    public function getActiveUserRoute(int $userId): UserActiveRouteResource
    {
        return UserActiveRouteResource::make(
            $this->routeService->getActiveUserRoute($userId)
        );
    }

    /**
     * @param ChangeUserRouteRequest $changeActiveUserRouteRequest
     * @return UserActiveRouteResource
     * @throws RouteIsCompleted
     */
    public function changeActiveUserRoute(ChangeUserRouteRequest $changeActiveUserRouteRequest): UserActiveRouteResource
    {
        $changeActiveUserRouteDto = ChangeUserRouteDtoMapper::fromRequest($changeActiveUserRouteRequest);
        return UserActiveRouteResource::make(
            $this->routeService->changeActiveUserRoute($changeActiveUserRouteDto)
        );
    }

    /**
     * @param GetUserRoutesRequest $getUserRoutesRequest
     * @return RouteCursorResource
     */
    public function getFavoriteUserRoutes(GetUserRoutesRequest $getUserRoutesRequest): RouteCursorResource
    {
        $getUserRoutesDto = GetUserRoutesDtoMapper::fromRequest($getUserRoutesRequest);
        return RouteCursorResource::make(
            $this->routeService->getFavoriteUserRoutes($getUserRoutesDto)
        );
    }

    /**
     * @param ChangeUserRouteRequest $changeUserRouteRequest
     * @return RouteResource
     */
    public function addRouteToUserFavorite(ChangeUserRouteRequest $changeUserRouteRequest): RouteResource
    {
        $changeUserRouteDto = ChangeUserRouteDtoMapper::fromRequest($changeUserRouteRequest);
        return RouteResource::make(
            $this->routeService->addRouteToUserFavorite($changeUserRouteDto)
        );
    }

    /**
     * @param int $userId
     * @param int $routeId
     * @return Response
     */
    public function deleteRouteFromUserFavorite(int $userId, int $routeId): Response
    {
        $this->routeService->deleteRouteFromUserFavorite($userId, $routeId);
        return response()->noContent();
    }
}
