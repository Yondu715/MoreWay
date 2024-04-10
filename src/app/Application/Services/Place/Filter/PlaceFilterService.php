<?php

namespace App\Application\Services\Place\Filter;

use App\Application\Contracts\In\Services\IPlaceFilterService;
use App\Application\Contracts\Out\Repositories\ILocalityRepository;
use App\Application\Contracts\Out\Repositories\ITypeRepository;
use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;

class PlaceFilterService implements IPlaceFilterService
{
    public function __construct(
        private readonly ILocalityRepository $localityRepository,
        private readonly ITypeRepository $typeRepository
    ) {}

    /**
     * @return PlaceFilterDto
     */
    public function getFilters(): PlaceFilterDto
    {
        return PlaceFilterDto::fromFilters([
            'localities' => $this->localityRepository->all(),
            'types' => $this->typeRepository->all(),
            'minDistance' => 1,
            'maxDistance' => 700
        ]);
    }
}