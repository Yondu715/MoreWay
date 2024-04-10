<?php

namespace App\Application\DTO\Out\Place\Locality;

use App\Infrastructure\Database\Models\Locality;
use Illuminate\Support\Collection;

class LocalityDto
{
    public readonly int $id;
    public readonly string $name;

    public function __construct(
        int $id,
        string $name,
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @param Locality $locality
     * @return self
     */
    public static function fromLocalityModel(Locality $locality): self
    {
        return new self(
            id: $locality->id,
            name: $locality->name,
        );
    }

    /**
     * @param Collection<int, Locality> $localities
     * @return Collection<int, LocalityDto>
     */
    public static function fromLocalityCollection(Collection $localities): Collection
    {
        return $localities->map(function ($locality) {
            return self::fromLocalityModel($locality);
        });
    }
}
