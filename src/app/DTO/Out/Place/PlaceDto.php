<?php

namespace App\DTO\Out\Place;

use App\Lib\HashId\HashManager;
use App\Models\Locality;
use App\Models\Place;

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
    public readonly Locality $locality;



    public function __construct(
        float $distance,
        string $id,
        string $name,
        float $lat,
        float $lon,
        ?float $rating,
        string $description,
        array $images,
        Locality $locality,
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
     * @param float $distance
     * @param float $rating
     * @return self
     */
    public static function fromPlaceModel(Place $place, float $distance, float $rating): self
    {
        return new self(
            distance: $distance,
            id: $place->id,
            name: $place->name,
            lat: $place->lat,
            lon: $place->lon,
            rating: $rating,
            description: $place->description,
            images: $place->images()->get()->all(),
            locality: $place->locality
        );
    }

}
