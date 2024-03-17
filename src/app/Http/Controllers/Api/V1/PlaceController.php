<?php

namespace App\Http\Controllers\Api\V1;

use App\DTO\In\Place\GetPlaceDto;
use App\Exceptions\Place\PlaceNotFound;
use App\Http\Controllers\Controller;
use App\Http\Requests\Place\GetPlaceRequest;
use App\Http\Resources\Place\PlaceResource;
use App\Services\Place\PlaceService;

class PlaceController extends Controller
{
    public function __construct(private readonly PlaceService $placeService){}

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
}
