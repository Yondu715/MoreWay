<?php

namespace App\Application\DTO\Out\Place;

use App\Application\DTO\Out\Place\Image\ImageDto;
use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Application\DTO\Out\Place\Type\PlaceTypeDto;
use App\Infrastructure\Database\Models\Place;
use Illuminate\Support\Collection;

class PlaceDto
{
    public readonly ?float $distance;
    public readonly int $id;
    public readonly string $name;
    public readonly float $lat;
    public readonly float $lon;
    public readonly ?float $rating;
    public readonly string $description;
    public readonly Collection $images;
    public readonly LocalityDto $locality;
    public readonly PlaceTypeDto $type;

    public function __construct(
        ?float       $distance,
        string       $id,
        string       $name,
        float        $lat,
        float        $lon,
        ?float       $rating,
        string       $description,
        Collection   $images,
        LocalityDto  $locality,
        PlaceTypeDto $type,
    ) {
        $this->distance = $distance;
        $this->id = $id;
        $this->name = $name;
        $this->lat = $lat;
        $this->lon = $lon;
        $this->rating = $rating;
        $this->description = $description;
        $this->images = $images;
        $this->locality = $locality;
        $this->type = $type;
    }

    /**
     * @param Place $place
     * @param float|null $distance
     * @return self
     */
    public static function fromPlaceModel(Place $place, float $distance = null): self
    {
        return new self(
            distance: $distance ?? $place->distance,
            id: $place->id,
            name: $place->name,
            lat: $place->lat,
            lon: $place->lon,
            rating: $place->rating(),
            description: $place->description,
            images: ImageDto::fromImageCollection($place->images),
            locality: LocalityDto::fromLocalityModel($place->locality),
            type: PlaceTypeDto::fromTypeModel($place->type)
        );
    }
}
