<?php

namespace App\Application\DTO\In\Place\Review;

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
}
