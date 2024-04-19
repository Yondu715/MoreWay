<?php

namespace App\Application\DTO\Out\Place;

use App\Application\DTO\Out\Place\Locality\LocalityDto;
use App\Application\DTO\Out\Place\Type\PlaceTypeDto;
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
        int          $id,
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
}
