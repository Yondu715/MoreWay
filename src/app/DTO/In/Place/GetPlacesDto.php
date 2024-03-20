<?php

namespace App\DTO\In\Place;



use App\Http\Requests\Place\GetPlacesRequest;

class GetPlacesDto
{
    public readonly float $lat;
    public readonly float $lon;
    public readonly ?string $cursor;
    public readonly ?string $search;
    public readonly ?string $sort;
    public readonly ?int $sortType;
    public readonly ?string $locality;
    public readonly ?string $type;


    public function __construct(
        float $lat,
        float $lon,
        ?string $cursor,
        ?string $search,
        ?string $sort,
        ?int $sortType,
        ?string $locality,
        ?string $type
    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->cursor = $cursor;
        $this->search = $search;
        $this->sort = $sort;
        $this->sortType = $sortType;
        $this->locality = $locality;
        $this->type = $type;
    }

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return self
     */
    public static function fromRequest(GetPlacesRequest $getPlacesRequest): self
    {
        return new self(
            lat: $getPlacesRequest->lat,
            lon: $getPlacesRequest->lon,
            cursor: $getPlacesRequest->cursor,
            search: $getPlacesRequest->search,
            sort: $getPlacesRequest->sort,
            sortType: $getPlacesRequest->sortType,
            locality: $getPlacesRequest->locality,
            type: $getPlacesRequest->type
        );
    }
}
