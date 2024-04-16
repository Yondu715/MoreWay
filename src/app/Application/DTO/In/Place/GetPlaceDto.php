<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Place\GetPlaceRequest;

class GetPlaceDto
{
    public readonly int $id;
    public readonly float $lat;
    public readonly float $lon;

    public function __construct(
        int $id,
        float $lat,
        float $lon
    ) {
        $this->id = $id;
        $this->lat = $lat;
        $this->lon = $lon;
    }

    /**
     * @param GetPlaceRequest $getPlaceRequest
     * @return self
     */
    public static function fromRequest(GetPlaceRequest $getPlaceRequest): self
    {
        return new self(
            id: $getPlaceRequest->route('placeId'),
            lat: $getPlaceRequest->lat,
            lon: $getPlaceRequest->lon
        );
    }
}
