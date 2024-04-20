<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Route\Constructor\IRouteConstructorService;
use App\Application\Contracts\In\Services\Route\Filter\IRouteFilterService;
use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Application\Exceptions\Filter\FilterOutOfRange;
use App\Application\Exceptions\Route\Constructor\InvalidRoutePointIndex;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;
use App\Infrastructure\Http\Requests\Route\Constructor\ChangeUserRouteConstructorRequest;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Infrastructure\Http\Requests\Route\GetRoutesRequest;
use App\Infrastructure\Http\Resources\Review\ReviewCursorResource;
use App\Infrastructure\Http\Resources\Review\ReviewResource;
use App\Infrastructure\Http\Resources\Route\Constructor\ConstructorResource;
use App\Infrastructure\Http\Resources\Route\Filter\RouteFilterResource;
use App\Infrastructure\Http\Resources\Route\RouteCursorResource;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use App\Utils\Mappers\In\Route\Constructor\ConstructorDtoMapper;
use App\Utils\Mappers\In\Route\CreateRouteDtoMapper;
use App\Utils\Mappers\In\Route\GetRoutesDtoMapper;
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

    public function getUserRouteConstructor(int $userId): ConstructorResource
    {
        return ConstructorResource::make(
            $this->constructorService->get($userId)
        );
    }

//    public function completedRoutePoint(CompletedRoutePointRequest $completedRoutePointRequest): void
//    {
//        $completedRoutePointDto = CompletedRoutePointDtoMapper::fromRequest();
//        $this->routeService->completedRoutePoint($completedRoutePointDto);
//    }
}
