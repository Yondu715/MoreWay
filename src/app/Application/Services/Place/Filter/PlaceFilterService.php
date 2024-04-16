<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Services\Place\Filter;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\Place\Filter\IPlaceFilterService;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Locality\ILocalityRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Repositories\Place\Type\IPlaceTypeRepository;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Place\Filter\PlaceFilterDto;

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
