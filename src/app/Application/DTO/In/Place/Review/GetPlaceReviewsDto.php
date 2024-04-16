<?php

namespace App\Application\DTO\In\Place\Review;

use App\Infrastructure\Http\Requests\Review\GetReviewsRequest;

class GetPlaceReviewsDto
{
    public readonly int $placeId;
    public readonly ?string $cursor;

    public readonly int $limit;

    public function __construct(
        int $placeId,
        ?string $cursor,
        int $limit
    ) {
        $this->placeId = $placeId;
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
            placeId: $getReviewsRequest->route('placeId'),
            cursor: $getReviewsRequest->cursor,
            limit: $getReviewsRequest->limit ?? 2
        );
    }
}
