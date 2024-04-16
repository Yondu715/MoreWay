<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Route\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Review\GetReviewsRequest;

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
