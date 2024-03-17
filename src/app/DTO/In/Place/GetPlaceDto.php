<?php

namespace App\DTO\In\Place;

use App\Http\Requests\Place\GetPlaceRequest;
use App\Lib\HashId\HashManager;

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
            lat: $getPlaceRequest->query('lat'),
            lon: $getPlaceRequest->query('lon')
        );
    }
}
