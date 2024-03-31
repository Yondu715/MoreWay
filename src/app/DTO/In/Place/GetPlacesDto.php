<?php

namespace App\DTO\In\Place;



use App\Exceptions\Filter\FilterOutOfRange;
use App\Http\Requests\Place\GetPlacesRequest;

class GetPlacesDto
{
    public readonly float $lat;
    public readonly float $lon;
    public readonly ?string $cursor;
    public readonly array $filter;
    public readonly int $limit;

    public function __construct(
        float $lat,
        float $lon,
        ?string $cursor,
        array $filter,
        int $limit

    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->cursor = $cursor;
        $this->filter = $filter;
        $this->limit = $limit;
    }

    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return self
     * @throws FilterOutOfRange
     */
    public static function fromRequest(GetPlacesRequest $getPlacesRequest): self
    {
        return new self(
            lat: $getPlacesRequest->lat,
            lon: $getPlacesRequest->lon,
            cursor: $getPlacesRequest->cursor,
            filter: [
                'locality' => $getPlacesRequest->locality ? explode(",", $getPlacesRequest->locality) : null,
                'type' => $getPlacesRequest->type ? explode(",", $getPlacesRequest->type) : null,
                'rating' => $getPlacesRequest->rating ? array_reduce(
                    explode("-", $getPlacesRequest->rating),
                    function ($range) use ($getPlacesRequest) {
                        $ratingRanges = explode("-", $getPlacesRequest->rating);
                        if (count($ratingRanges) !== 2) {
                            throw new FilterOutOfRange();
                        }
                        $range['from'] = (float)$ratingRanges[0];
                        $range['to'] = (float)$ratingRanges[1];
                        return $range;
                    }
                ) : null,
                'distance' => $getPlacesRequest->distance ? array_reduce(
                    explode("-", $getPlacesRequest->distance),
                    function ($range) use ($getPlacesRequest) {
                        $distanceRanges = explode("-", $getPlacesRequest->distance);
                        if (count($distanceRanges) !== 2) {
                            throw new FilterOutOfRange();
                        }
                        $range['from'] = (float)$distanceRanges[0];
                        $range['to'] = (float)$distanceRanges[1];
                        return $range;
                    }
                ) : null,
                'sort' => $getPlacesRequest->sort && $getPlacesRequest->sortType ?
                    [
                        'sort' => $getPlacesRequest->sort,
                        'sortType' => ((int)$getPlacesRequest->sortType === 1) ? 'desc' : 'asc'
                    ] : null,
                'search' => $getPlacesRequest->search,
            ],
            limit: $getPlacesRequest->limit ?? 2
        );
    }
}
