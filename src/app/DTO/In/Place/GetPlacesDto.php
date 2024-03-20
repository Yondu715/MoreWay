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
    public readonly array $filter;

    public function __construct(
        float $lat,
        float $lon,
        ?string $cursor,
        ?string $search,
        ?string $sort,
        ?int $sortType,
        array $filter
    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->cursor = $cursor;
        $this->search = $search;
        $this->sort = $sort;
        $this->sortType = $sortType;
        $this->filter = $filter;
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
            filter: [
                'locality' => ($getPlacesRequest->locality === null)
                    ? null : explode(",", $getPlacesRequest->locality),
                'type' => ($getPlacesRequest->type === null)
                    ? null : explode(",", $getPlacesRequest->type),
                'sort' => ($getPlacesRequest->sort === null || $getPlacesRequest->sortType === null)
                    ? null : [$getPlacesRequest->sort, ($getPlacesRequest->sortType === 1) ? 'desk' : 'ask']
            ]
        );
    }
}
