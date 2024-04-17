<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Application\Contracts\In\Services\Place\IPlaceService;
use App\Application\Contracts\In\Services\Place\Review\IPlaceReviewService;
use App\Application\Exceptions\Place\PlaceNotFound;
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
use App\Utils\Mappers\In\Place\GetPlaceDtoMapper;
use App\Utils\Mappers\In\Place\Review\GetPlaceReviewsDtoMapper;
use App\Utils\Mappers\In\Place\GetPlacesDtoMapper;
use App\Utils\Mappers\In\Place\Review\CreatePlaceReviewDtoMapper;

class PlaceController extends Controller
{
    public function __construct(
        private readonly IPlaceService $placeService,
        private readonly IPlaceReviewService $reviewService,
        private readonly IPlaceFilterService $filterService
    ) {
    }

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return PlaceCursorResource
     * @throws ApiException
     */
    public function getPlaces(GetPlacesRequest $getPlacesRequest): PlaceCursorResource
    {
        $getPlacesDto = GetPlacesDtoMapper::fromRequest($getPlacesRequest);
        return PlaceCursorResource::make(
            $this->placeService->getPlaces($getPlacesDto)
        );
    }

    /**
     * @param GetPlaceRequest $getPlaceRequest
     * @return PlaceResource
     * @throws ApiException
     */
    public function getPlace(GetPlaceRequest $getPlaceRequest): PlaceResource
    {
        try {
            $getPlaceDto = GetPlaceDtoMapper::fromRequest($getPlaceRequest);
            return PlaceResource::make(
                $this->placeService->getPlaceById($getPlaceDto)
            );
        } catch (PlaceNotFound $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return ReviewResource
     */
    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        $createReviewDto = CreatePlaceReviewDtoMapper::fromRequest($createReviewRequest);
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
        $getReviewsDto = GetPlaceReviewsDtoMapper::fromRequest($getReviewsRequest);
        return ReviewCursorResource::make(
            $this->reviewService->getReviews($getReviewsDto)
        );
    }

    /**
     * @return PlaceFilterResource
     * @throws ApiException
     */
    public function getFilters(): PlaceFilterResource
    {
        return PlaceFilterResource::make(
            $this->filterService->getFilters()
        );
    }
}
