<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\Place\CreateReviewDto;
use App\DTO\In\Place\GetPlaceDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\Place\CreateReviewRequest;
use App\Http\Requests\Place\GetPlaceRequest;
use App\Http\Resources\Place\PlaceResource;
use App\Http\Resources\Place\ReviewResource;
use App\Services\Place\PlaceService;
use App\Services\Place\Review\ReviewService;

class PlaceController extends Controller
{
    public function __construct(
        private readonly PlaceService $placeService,
        private readonly ReviewService $reviewService
    ){}

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

    public function createReview(CreateReviewRequest $createReviewRequest): ReviewResource
    {
        $createReviewDto = CreateReviewDto::fromRequest($createReviewRequest);

        return ReviewResource::make(
            $this->reviewService->create($createReviewDto)
        );
    }
}
