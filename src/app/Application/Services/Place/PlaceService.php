<?php

namespace App\Application\Services\Place;

use App\Application\Contracts\In\Services\IPlaceService;
use App\Application\Contracts\Out\Repositories\IPlaceRepository;
use App\Application\DTO\In\Place\GetPlaceDto;
use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\DTO\Out\Place\PlaceCursorDto;
use App\Application\DTO\Out\Place\PlaceDto;
use App\Application\Exceptions\Place\PlaceNotFound;
use Illuminate\Contracts\Pagination\CursorPaginator;

class PlaceService implements IPlaceService
{
    public function __construct(
        private readonly IPlaceRepository $placeRepository
    ) {
    }

    /**
     * @param GetPlaceDto $getPlaceDto
     * @return PlaceDto
     * @throws PlaceNotFound
     */
    public function getPlaceById(GetPlaceDto $getPlaceDto): PlaceDto
    {
        $place = $this->placeRepository->getPlaceById($getPlaceDto);
        return PlaceDto::fromPlaceModel($place);
    }

    /**
     * @param GetPlacesDto $getPlacesDto
     * @return array{data:array<PlaceDto>, next_cursor:string}
     */
    public function getPlaces(GetPlacesDto $getPlacesDto): array
    {
        return PlaceCursorDto::fromPaginator($this->placeRepository->getPlaces($getPlacesDto));
    }
}
