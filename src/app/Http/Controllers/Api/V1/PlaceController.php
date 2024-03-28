<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\In\Place\Review\CreateReviewDto;
use App\DTO\In\Place\Review\GetReviewsDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Place\GetPlaceRequest;
use App\Http\Requests\Place\GetPlacesRequest;
use App\Http\Requests\Place\Review\CreateReviewRequest;
use App\Http\Requests\Place\Review\GetReviewsRequest;
use App\Http\Resources\Place\PlaceCollection;
use App\Http\Resources\Place\PlaceResource;
use App\Http\Resources\Place\Review\ReviewCollection;
use App\Http\Resources\Place\Review\ReviewResource;
use App\Services\Place\Interfaces\IPlaceService;
use App\Services\Place\Review\Interfaces\IReviewService;
use Exception;

class PlaceController extends Controller
{
    public function __construct(
        private readonly IPlaceService $placeService,
        private readonly IReviewService $reviewService
    ){}

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return PlaceCollection
     * @throws Exception
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
     * @throws Exception
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
     * @throws Exception
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
