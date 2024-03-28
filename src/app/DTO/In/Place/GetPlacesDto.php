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

    public function __construct(
        float $lat,
        float $lon,
        ?string $cursor,
        array $filter
    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->cursor = $cursor;
        $this->filter = $filter;
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
                'locality' => ($getPlacesRequest->locality === null)
                    ? null : explode(",", $getPlacesRequest->locality),
                'type' => ($getPlacesRequest->type === null)
                    ? null : explode(",", $getPlacesRequest->type),
                'rating' => ($getPlacesRequest->rating === null)
                    ? null : array_reduce(
                        explode("-", $getPlacesRequest->rating),
                        function ($range) use($getPlacesRequest) {
                            $ratingRanges = explode("-", $getPlacesRequest->rating);
                            if(count($ratingRanges) !== 2){
                                throw new FilterOutOfRange();
                            }
                            $range['from'] = (float)$ratingRanges[0];
                            $range['to'] = (float)$ratingRanges[1];
                            return $range;
                        }),
                'distance' => ($getPlacesRequest->distance === null)
                    ? null : array_reduce(
                        explode("-", $getPlacesRequest->distance),
                        function ($range) use($getPlacesRequest) {
                            $distanceRanges = explode("-", $getPlacesRequest->distance);
                            if(count($distanceRanges) !== 2){
                                throw new FilterOutOfRange();
                            }
                            $range['from'] = (float)$distanceRanges[0];
                            $range['to'] = (float)$distanceRanges[1];
                            return $range;
                        }),
                'sort' => ($getPlacesRequest->sort === null || $getPlacesRequest->sortType === null)
                    ? null : ['sort' => $getPlacesRequest->sort,
                        'sortType' => ((int)$getPlacesRequest->sortType === 1) ? 'desc' : 'asc'],
                'search' => $getPlacesRequest->search,
            ]
        );
    }
}
