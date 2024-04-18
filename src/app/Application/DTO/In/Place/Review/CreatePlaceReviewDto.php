<?php

namespace App\Application\DTO\In\Place\Review;

class CreatePlaceReviewDto
{
    public readonly int $placeId;
    public readonly int $userId;
    public readonly int $rating;
    public readonly ?string $text;

    public function __construct(
        int $placeId,
        int $userId,
        int $rating,
        ?string $text
    ) {
        $this->placeId = $placeId;
        $this->userId = $userId;
        $this->rating = $rating;
        $this->text = $text;
    }
}
