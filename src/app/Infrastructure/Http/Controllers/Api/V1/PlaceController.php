<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Application\Contracts\In\Services\Place\IPlaceService;
use App\Application\Contracts\In\Services\Place\Review\IPlaceReviewService;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Place\GetPlaceRequest;
use App\Infrastructure\Http\Requests\Place\GetPlacesRequest;
use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;
use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;
use App\Infrastructure\Http\Resources\Place\Filter\PlaceFilterResource;
use App\Infrastructure\Http\Resources\Place\PlaceCursorResource;
use App\Infrastructure\Http\Resources\Place\PlaceResource;
use App\Infrastructure\Http\Resources\Review\ReviewCursorResource;
use App\Infrastructure\Http\Resources\Review\ReviewResource;
use Exception;

class PlaceController extends Controller
{
    public function __construct(
        private readonly IPlaceService $placeService,
        private readonly IPlaceReviewService $reviewService,
        private readonly IPlaceFilterService $filterService
    ) {}

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return PlaceCursorResource
     * @throws Exception
     */
    public function getPlaces(GetPlacesRequest $getPlacesRequest): PlaceCursorResource
    {
        try {
            $getPlacesDto = GetPlacesDto::fromRequest($getPlacesRequest);
            return PlaceCursorResource::make(
                $this->placeService->getPlaces($getPlacesDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetPlaceRequest $getPlaceRequest
     * @return PlaceResource
     * @throws Exception
     */
    public function getPlace(GetPlaceRequest $getPlaceRequest): PlaceResource
    {
        try {
            $getPlaceDto = GetPlaceDto::fromRequest($getPlaceRequest);
            return PlaceResource::make(
                $this->placeService->getPlaceById($getPlaceDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return ReviewResource
     * @throws Exception
     */
    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        try {
            $createReviewDto = CreatePlaceReviewDto::fromRequest($createReviewRequest);
            return ReviewResource::make(
                $this->reviewService->createReviews($createReviewDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return ReviewCursorResource
     * @throws Exception
     */
    public function getReviews(GetReviewsRequest $getReviewsRequest): ReviewCursorResource
    {
        try {
            $getReviewsDto = GetPlaceReviewsDto::fromRequest($getReviewsRequest);
            return ReviewCursorResource::make(
                $this->reviewService->getReviews($getReviewsDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @return PlaceFilterResource
     * @throws ApiException
     */
    public function getFilters(): PlaceFilterResource
    {
        try {
            return PlaceFilterResource::make(
                $this->filterService->getFilters()
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
