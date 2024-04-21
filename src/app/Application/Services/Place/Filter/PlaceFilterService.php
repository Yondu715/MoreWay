<?php

namespace App\Application\Services\Place\Filter;

use App\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Application\DTO\Out\Place\Filter\PlaceFilterDto;
use App\Utils\Mappers\Out\Place\Filter\PlaceFilterDtoMapper;

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
        return PlaceFilterDtoMapper::fromFilters([
            'localities' => $this->localityRepository->getAll(),
            'types' => $this->typeRepository->getAll(),
            'minDistance' => 0,
            'maxDistance' => 700
        ]);
    }
}
