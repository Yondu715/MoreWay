<?php

namespace App\DTO\In\Place\Review;

use App\Http\Requests\Place\Review\GetReviewsRequest;

class GetReviewsDto
{
    public readonly int $placeId;
    public readonly ?string $cursor;

    public function __construct(
        int $placeId,
        ?string $cursor,
    ) {
        $this->placeId = $placeId;
        $this->cursor = $cursor;
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
        );
    }
}
