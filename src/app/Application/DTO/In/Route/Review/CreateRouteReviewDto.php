<?php

namespace App\Application\DTO\In\Route\Review;

use App\Infrastructure\Http\Requests\Route\CreateRouteReviewRequest;

class CreateRouteReviewDto
{
    public readonly int $userId;
    public readonly ?string $text;
    public readonly int $rating;

    public function __construct(
        int $userId,
        ?string $text,
        int $rating
    ) {
        $this->userId = $userId;
        $this->text = $text;
        $this->rating = $rating;
    }

    public static function fromRequest(CreateRouteReviewRequest $createRouteReviewRequest): self
    {
        return new self(
            userId: $createRouteReviewRequest->userId,
            text: $createRouteReviewRequest->text,
            rating: $createRouteReviewRequest->rating
        );
    }
}
