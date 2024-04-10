<?php

namespace App\Application\DTO\Out\Place\Type;

use App\Infrastructure\Database\Models\PlaceType;
use Illuminate\Support\Collection;

class TypeDto
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
     * @param PlaceType $placeType
     * @return self
     */
    public static function fromTypeModel(PlaceType $placeType): self
    {
        return new self(
            id: $placeType->id,
            name: $placeType->name,
        );
    }

    /**
     * @param Collection<int, PlaceType> $types
     * @return Collection
     */
    public static function fromTypeCollection(Collection $types): Collection
    {
        return $types->map(function ($type) {
            return $type->name;
        });
    }
}
