<?php

namespace App\Utils\Mappers\Out\Place\Locality;

use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Infrastructure\Database\Models\Locality;
use Illuminate\Support\Collection;

class LocalityDtoMapper
{
    /**
     * @param Locality $locality
     * @return LocalityDto
     */
    public static function fromLocalityModel(Locality $locality): LocalityDto
    {
        return new LocalityDto(
            id: $locality->id,
            name: $locality->name,
        );
    }

    /**
     * @param Collection<int, Locality> $localities
     * @return Collection<int, string>
     */
    public static function fromLocalityCollection(Collection $localities): Collection
    {
        return $localities->map(function ($locality) {
            return $locality->name;
        });
    }
}