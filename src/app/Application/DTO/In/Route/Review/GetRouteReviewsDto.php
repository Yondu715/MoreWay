<?php

namespace App\Application\DTO\In\Route\Review;

use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;

class GetRouteReviewsDto
{
    public readonly int $routeId;
    public readonly ?string $cursor;
    public readonly int $limit;

    public function __construct(
        int $routeId,
        ?string $cursor,
        int $limit
    ) {
        $this->routeId = $routeId;
        $this->cursor = $cursor;
        $this->limit = $limit;
    }

    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return self
     */
    public static function fromRequest(GetReviewsRequest $getReviewsRequest): self
    {
        return new self(
            routeId: $getReviewsRequest->route('routeId'),
            cursor: $getReviewsRequest->cursor,
            limit: $getReviewsRequest->limit ?? 2
        );
    }
}
