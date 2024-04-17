<?php

namespace App\Application\DTO\In\Route\Review;

class CreateRouteReviewDto
{
    public readonly int $routeId;
    public readonly int $userId;
    public readonly int $rating;
    public readonly ?string $text;

    public function __construct(
        int $routeId,
        int $userId,
        int $rating,
        ?string $text
    ) {
        $this->routeId = $routeId;
        $this->userId = $userId;
        $this->rating = $rating;
        $this->text = $text;
    }
}
