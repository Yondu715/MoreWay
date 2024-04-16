<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Controllers\Api\V1;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\IRouteService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Route\Review\IRouteReviewService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\CreateRouteDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\CreateRouteReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review\GetRouteReviewsDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Review\CreateReviewRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Review\GetReviewsRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Route\CreateRouteRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Review\ReviewCursorResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Review\ReviewResource;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Route\RouteResource;
use Throwable;

class RouteController extends Controller
{
    public function __construct(
        private readonly IRouteService $routeService,
        private readonly IRouteReviewService $reviewService,
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

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return ReviewResource
     * @throws Throwable
     */
    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        try {
            $createReviewDto = CreateRouteReviewDto::fromRequest($createReviewRequest);
            return ReviewResource::make(
                $this->reviewService->createReviews($createReviewDto)
            );
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return ReviewCursorResource
     * @throws Throwable
     */
    public function getReviews(GetReviewsRequest $getReviewsRequest): ReviewCursorResource
    {
        try {
            $getReviewsDto = GetRouteReviewsDto::fromRequest($getReviewsRequest);
            return ReviewCursorResource::make(
                $this->reviewService->getReviews($getReviewsDto)
            );
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
