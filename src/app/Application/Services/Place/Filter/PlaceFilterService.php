<?php

namespace App\Application\Services\Place\Filter;

use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;
use App\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Application\DTO\Out\Place\Type\PlaceTypeDto;

class PlaceFilterService implements IPlaceFilterService
{
    public function __construct(
        private readonly ILocalityRepository $localityRepository,
        private readonly IPlaceTypeRepository $typeRepository
    ) {
    }

    /**
     * @return PlaceFilterDto
     */
    public function getFilters(): PlaceFilterDto
    {
        return new PlaceFilterDto(
            localities: $this->localityRepository->getAll()->map(fn (LocalityDto $localityDto) => $localityDto->name),
            types: $this->typeRepository->getAll()->map(fn (PlaceTypeDto $placeTypeDto) => $placeTypeDto->name),
            minDistance: 0,
            maxDistance: 700
        );
    }
}
