<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

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
use App\Infrastructure\Http\Resources\Place\PlaceCursorResource;
use App\Infrastructure\Http\Resources\Place\PlaceResource;
use App\Infrastructure\Http\Resources\Place\Review\PlaceReviewCursorResource;
use App\Infrastructure\Http\Resources\Place\Review\PlaceReviewResource;
use Exception;

class PlaceController extends Controller
{
    public function __construct(
        private readonly IPlaceService $placeService,
        private readonly IPlaceReviewService $reviewService
    ) {}

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return PlaceCursorResource
     * @throws Exception
     */
    public function getPlaces(GetPlacesRequest $getPlacesRequest): PlaceCursorResource
    {
        try {
            $getPlacesRequest = GetPlacesDto::fromRequest($getPlacesRequest);
            return PlaceCursorResource::make(
                $this->placeService->getPlaces($getPlacesRequest)
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
     * @param CreatePlaceReviewRequest $createReviewRequest
     * @return PlaceReviewResource
     * @throws Exception
     */
    public function createReview(CreatePlaceReviewRequest $createReviewRequest): PlaceReviewResource
    {
        try {
            $createReviewDto = CreatePlaceReviewDto::fromRequest($createReviewRequest);
            return PlaceReviewResource::make(
                $this->reviewService->createReviews($createReviewDto)
            );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetPlaceReviewsRequest $getReviewsRequest
     * @return PlaceReviewCursorResource
     * @throws Exception
     */
    public function getReviews(GetPlaceReviewsRequest $getReviewsRequest): PlaceReviewCursorResource
    {
        try {
        $getReviewsDto = GetPlaceReviewsDto::fromRequest($getReviewsRequest);
        return PlaceReviewCursorResource::make(
            $this->reviewService->getReviews($getReviewsDto)
        );
        } catch (Exception $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
