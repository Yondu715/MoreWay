<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Route\IRouteService;
use App\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Application\DTO\In\Route\CreateRouteDto;
use App\Application\DTO\In\Route\GetRoutesDto;
use App\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Application\Exceptions\Filter\FilterOutOfRange;
use App\Application\Exceptions\Route\FailedToCreateRoute;
use App\Application\Exceptions\Route\RouteNotFound;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;
use App\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Infrastructure\Http\Requests\Route\GetRoutesRequest;
use App\Infrastructure\Http\Resources\Review\ReviewCursorResource;
use App\Infrastructure\Http\Resources\Review\ReviewResource;
use App\Infrastructure\Http\Resources\Route\RouteCursorResource;
use App\Infrastructure\Http\Resources\Route\RouteResource;

class RouteController extends Controller
{
    public function __construct(
        private readonly IRouteService $routeService,
        private readonly IRouteReviewService $reviewService,
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
            $createRouteDto = CreateRouteDto::fromRequest($createRouteRequest);
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
     * @throws FilterOutOfRange
     */
    public function getRoutes(GetRoutesRequest $getRoutesRequest): RouteCursorResource
    {
        try {
            $getRoutesDto = GetRoutesDto::fromRequest($getRoutesRequest);
            return RouteCursorResource::make(
                $this->routeService->getRoutes($getRoutesDto)
            );
        } catch (RouteNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return ReviewResource
     */
    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        $createReviewDto = CreateRouteReviewDto::fromRequest($createReviewRequest);
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
        $getReviewsDto = GetRouteReviewsDto::fromRequest($getReviewsRequest);
        return ReviewCursorResource::make(
            $this->reviewService->getReviews($getReviewsDto)
        );
    }
}
