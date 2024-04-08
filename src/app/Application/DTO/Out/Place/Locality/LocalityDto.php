<?php

namespace App\Application\DTO\Out\Place\Locality;

use App\Infrastructure\Database\Models\Locality;

class LocalityDto
{
    public readonly int $id;
    public readonly string $name;

    public function __construct(
        string $id,
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
}
