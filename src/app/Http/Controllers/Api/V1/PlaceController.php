<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Exceptions\Review\FailedToCreateReview;
use App\Http\Controllers\Controller;
use App\Http\Requests\Place\GetPlaceRequest;
use App\Http\Requests\Place\GetPlacesRequest;
use App\Http\Requests\Place\Review\CreateReviewRequest;
use App\Http\Requests\Place\Review\GetReviewsRequest;
use App\Http\Resources\Place\PlaceCollection;
use App\Http\Resources\Place\PlaceResource;
use App\Http\Resources\Place\Review\ReviewCollection;
use App\Http\Resources\Place\Review\ReviewResource;
use App\Services\Place\PlaceService;
use App\Services\Place\Review\ReviewService;

class PlaceController extends Controller
{
    public function __construct(
        private readonly PlaceService $placeService,
        private readonly ReviewService $reviewService
    ){}

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return PlaceCollection
     */
    public function getPlaces(GetPlacesRequest $getPlacesRequest): PlaceCollection
    {
        $getPlacesRequest = GetPlacesDto::fromRequest($getPlacesRequest);

        return PlaceCollection::make(
            $this->placeService->getPlaces($getPlacesRequest)
        );
    }

    /**
     * @param GetPlaceRequest $getPlaceRequest
     * @return PlaceResource
     * @throws PlaceNotFound
     */
    public function getPlace(GetPlaceRequest $getPlaceRequest): PlaceResource
    {
        $getPlaceDto = GetPlaceDto::fromRequest($getPlaceRequest);

        return PlaceResource::make(
            $this->placeService->getPlaceById($getPlaceDto)
        );
    }

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return ReviewResource
     * @throws FailedToCreateReview
     */
    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        $createReviewDto = CreateReviewDto::fromRequest($createReviewRequest);

        return ReviewResource::make(
            $this->reviewService->createReviews($createReviewDto)
        );
    }

    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return ReviewCollection
     */
    public function getReviews(GetReviewsRequest $getReviewsRequest): ReviewCollection
    {
        $getReviewsDto = GetReviewsDto::fromRequest($getReviewsRequest);

        return ReviewCollection::make(
                $this->reviewService->getReviews($getReviewsDto)
        );
    }
}
