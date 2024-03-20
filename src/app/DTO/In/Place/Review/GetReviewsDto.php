<?php

namespace App\DTO\In\Place\Review;

use App\Http\Requests\Place\Review\GetReviewsRequest;

class GetReviewsDto
{
    public readonly int $place_id;
    public readonly ?string $cursor;

    public function __construct(
        int $place_id,
        ?string $cursor,
    ) {
        $this->place_id = $place_id;
        $this->cursor = $cursor;
    }

    /**
     * @param GetReviewsRequest $getReviewsRequest
     * @return self
     */
    public static function fromRequest(GetReviewsRequest $getReviewsRequest): self
    {
        return new self(
            place_id: $getReviewsRequest->route('placeId'),
            cursor: $getReviewsRequest->cursor,
        );
    }
}
