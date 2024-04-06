<?php

namespace App\Application\DTO\Out\Place;

use App\Infrastructure\Database\Models\Locality;
use App\Infrastructure\Database\Models\Place;

class PlaceDto
{
    public readonly float $distance;
    public readonly string $id;
    public readonly string $name;
    public readonly float $lat;
    public readonly float $lon;
    public readonly ?float $rating;
    public readonly string $description;
    public readonly array $images;
    public readonly LocalityDto $locality;



    public function __construct(
        float $distance,
        string $id,
        string $name,
        float $lat,
        float $lon,
        ?float $rating,
        string $description,
        array $images,
        LocalityDto $locality,
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
    }

    /**
     * @param Place $place
     * @param ?float $rating
     * @return self
     */
    public static function fromPlaceModel(Place $place, ?float $rating): self
    {
        return new self(
            distance: $place->distance,
            id: $place->id,
            name: $place->name,
            lat: $place->lat,
            lon: $place->lon,
            rating: $rating,
            description: $place->description,
            images: $place->images->all(),
            locality: LocalityDto::fromLocalityModel($place->locality)
        );
    }

}
