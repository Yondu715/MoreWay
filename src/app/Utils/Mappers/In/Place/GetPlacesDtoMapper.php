<?php

namespace App\Utils\Mappers\In\Place;

use App\Application\DTO\In\Place\GetPlacesDto;
use App\Application\Exceptions\Filter\FilterOutOfRange;
use App\Infrastructure\Http\Requests\Place\GetPlacesRequest;

class GetPlacesDtoMapper
{
    /**
     * @param GetPlacesRequest $getPlacesRequest
     * @return GetPlacesDto
     * @throws FilterOutOfRange
     */
    public static function fromRequest(GetPlacesRequest $getPlacesRequest): GetPlacesDto
    {
        return new GetPlacesDto(
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