<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\Place\GetPlaceDto;
use App\DTO\In\Place\GetPlacesDto;
use App\DTO\In\PlaceReview\CreatePlaceReviewDto;
use App\DTO\In\PlaceReview\GetPlaceReviewsDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Place\GetPlaceRequest;
use App\Http\Requests\Place\GetPlacesRequest;
use App\Http\Requests\PlaceReview\CreatePlaceReviewRequest;
use App\Http\Requests\PlaceReview\GetPlaceReviewsRequest;
use App\Http\Resources\Place\PlaceCollection;
use App\Http\Resources\Place\PlaceResource;
use App\Http\Resources\PlaceReview\PlaceReviewCollection;
use App\Http\Resources\PlaceReview\PlaceReviewResource;
use App\Services\Place\Interfaces\IPlaceService;
use App\Services\PlaceReview\Interfaces\IPlaceReviewService;
use Exception;

class PlaceController extends Controller
{
    public function __construct(
        private readonly IPlaceService $placeService,
        private readonly IPlaceReviewService $reviewService
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
     * @param CreatePlaceReviewRequest $createReviewRequest
     * @return PlaceReviewResource
     * @throws Exception
     */
    public function createReview(CreatePlaceReviewRequest $createReviewRequest): PlaceReviewResource
    {
        $createReviewDto = CreatePlaceReviewDto::fromRequest($createReviewRequest);
        return PlaceReviewResource::make(
            $this->reviewService->createReviews($createReviewDto)
        );
    }

    /**
     * @param GetPlaceReviewsRequest $getReviewsRequest
     * @return PlaceReviewCollection
     */
    public function getReviews(GetPlaceReviewsRequest $getReviewsRequest): PlaceReviewCollection
    {
        $getReviewsDto = GetPlaceReviewsDto::fromRequest($getReviewsRequest);
        return PlaceReviewCollection::make(
                $this->reviewService->getReviews($getReviewsDto)
        );
    }
}
