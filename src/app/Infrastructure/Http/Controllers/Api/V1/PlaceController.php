<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\IPlaceFilterService;
use App\Application\Contracts\In\Services\IPlaceReviewService;
use App\Application\Contracts\In\Services\IPlaceService;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\In\Place\Review\CreatePlaceReviewDto;
use App\Application\DTO\In\Place\Review\GetPlaceReviewsDto;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Http\Controllers\Controller;
use App\Infrastructure\Http\Requests\Place\GetPlaceRequest;
use App\Infrastructure\Http\Requests\Place\GetPlacesRequest;
use App\Infrastructure\Http\Requests\Place\PlaceReview\CreatePlaceReviewRequest;
use App\Infrastructure\Http\Requests\Place\PlaceReview\GetPlaceReviewsRequest;
use App\Infrastructure\Http\Resources\Place\Filter\PlaceFilterResource;
use App\Infrastructure\Http\Resources\Place\PlaceCursorResource;
use App\Infrastructure\Http\Resources\Place\PlaceResource;
use App\Infrastructure\Http\Resources\Place\Review\PlaceReviewCursorResource;
use App\Infrastructure\Http\Resources\Place\Review\PlaceReviewResource;
use Throwable;

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
     * @throws ApiException
     */
    public function getPlaces(GetPlacesRequest $getPlacesRequest): PlaceCursorResource
    {
        try {
            $getPlacesDto = GetPlacesDto::fromRequest($getPlacesRequest);
            return PlaceCursorResource::make(
                $this->placeService->getPlaces($getPlacesDto)
            );
        } catch (Throwable $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetPlaceRequest $getPlaceRequest
     * @return PlaceResource
     * @throws ApiException
     */
    public function getPlace(GetPlaceRequest $getPlaceRequest): PlaceResource
    {
        try {
            $getPlaceDto = GetPlaceDto::fromRequest($getPlaceRequest);
            return PlaceResource::make(
                $this->placeService->getPlaceById($getPlaceDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }

    /**
     * @param CreatePlaceReviewRequest $createReviewRequest
     * @return PlaceReviewResource
     * @throws ApiException
     */
    public function createReview(CreatePlaceReviewRequest $createReviewRequest): PlaceReviewResource
    {
        try {
            $createReviewDto = CreatePlaceReviewDto::fromRequest($createReviewRequest);
            return PlaceReviewResource::make(
                $this->reviewService->createReviews($createReviewDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }

    /**
     * @param GetPlaceReviewsRequest $getReviewsRequest
     * @return PlaceReviewCursorResource
     * @throws ApiException
     */
    public function getReviews(GetPlaceReviewsRequest $getReviewsRequest): PlaceReviewCursorResource
    {
        try {
            $getReviewsDto = GetPlaceReviewsDto::fromRequest($getReviewsRequest);
            return PlaceReviewCursorResource::make(
                $this->reviewService->getReviews($getReviewsDto)
            );
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
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
        } catch (Throwable $th) {
            throw new ApiException($th->getMessage(), $th->getCode());
        }
    }
}
