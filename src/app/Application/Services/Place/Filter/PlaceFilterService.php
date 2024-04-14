<?php

namespace App\Application\Services\Place\Filter;

use App\Application\Contracts\In\Services\IPlaceFilterService;
use App\Application\Contracts\Out\Repositories\ILocalityRepository;
use App\Application\Contracts\Out\Repositories\IPlaceTypeRepository;
use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;

class PlaceFilterService implements IPlaceFilterService
{
    public function __construct(
        private readonly ILocalityRepository $localityRepository,
        private readonly IPlaceTypeRepository $typeRepository
    ) {}

    /**
     * @return PlaceFilterDto
     */
    public function getFilters(): PlaceFilterDto
    {
        return PlaceFilterDto::fromFilters([
            'localities' => $this->localityRepository->all(),
            'types' => $this->typeRepository->all(),
            'minDistance' => 0,
            'maxDistance' => 700
        ]);
    }
}
