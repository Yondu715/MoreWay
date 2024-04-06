<?php

namespace App\Application\DTO\In\PlaceReview;

use App\Infrastructure\Http\Requests\Place\PlaceReview\GetPlaceReviewsRequest;

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
     * @param GetPlaceReviewsRequest $getReviewsRequest
     * @return self
     */
    public static function fromRequest(GetPlaceReviewsRequest $getReviewsRequest): self
    {
        return new self(
            placeId: $getReviewsRequest->route('placeId'),
            cursor: $getReviewsRequest->cursor,
            limit: $getReviewsRequest->limit ?? 2
        );
    }
}
