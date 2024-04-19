<?php

namespace App\Application\DTO\In\Route;

use App\Application\Exceptions\Filter\FilterOutOfRange;
use App\Infrastructure\Http\Requests\Route\GetRoutesRequest;

class GetRoutesDto
{
    public readonly ?string $cursor;
    public array $filter;
    public readonly ?int $limit;

    public function __construct(
        ?string $cursor,
        array $filter,
        ?int $limit
    ) {
        $this->cursor = $cursor;
        $this->filter = $filter;
        $this->limit = $limit;
    }

    /**
     * @param GetRoutesRequest $getRoutesRequest
     * @return self
     * @throws FilterOutOfRange
     */
    public static function fromRequest(GetRoutesRequest $getRoutesRequest): self
    {
        return new self(
            cursor: $getRoutesRequest->cursor,
            filter: [
                'point' => $getRoutesRequest->point ? array_reduce(
                    explode("-", $getRoutesRequest->point),
                    function ($range) use ($getRoutesRequest) {
                        $pointRanges = explode("-", $getRoutesRequest->point);
                        if (count($pointRanges) !== 2) {
                            throw new FilterOutOfRange();
                        }
                        $range['from'] = (int)$pointRanges[0];
                        $range['to'] = (int)$pointRanges[1];
                        return $range;
                    }
                ) : null,
                'rating' => $getRoutesRequest->rating ? array_reduce(
                    explode("-", $getRoutesRequest->rating),
                    function ($range) use ($getRoutesRequest) {
                        $ratingRanges = explode("-", $getRoutesRequest->rating);
                        if (count($ratingRanges) !== 2) {
                            throw new FilterOutOfRange();
                        }
                        $range['from'] = (float)$ratingRanges[0];
                        $range['to'] = (float)$ratingRanges[1];
                        return $range;
                    }
                ) : null,
                'passing' => $getRoutesRequest->passing ? array_reduce(
                    explode("-", $getRoutesRequest->passing),
                    function ($range) use ($getRoutesRequest) {
                        $passingRanges = explode("-", $getRoutesRequest->passing);
                        if (count($passingRanges) !== 2) {
                            throw new FilterOutOfRange();
                        }
                        $range['from'] = (float)$passingRanges[0];
                        $range['to'] = (float)$passingRanges[1];
                        return $range;
                    }
                ) : null,
                'sort' => $getRoutesRequest->sort && $getRoutesRequest->sortType ?
                    [
                        'sort' => $getRoutesRequest->sort,
                        'sortType' => ((int)$getRoutesRequest->sortType === 1) ? 'desc' : 'asc'
                    ] : null,
                'search' => $getRoutesRequest->search,
            ],
            limit: $getRoutesRequest->limit ?? 2
        );
    }
}
