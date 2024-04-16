<?php

namespace App\Application\DTO\In\Route\Review;

use App\Infrastructure\Http\Requests\Review\CreateReviewRequest;

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

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return self
     */
    public static function fromRequest(CreateReviewRequest $createReviewRequest): self
    {
        return new self(
            routeId: $createReviewRequest->route('routeId'),
            userId: $createReviewRequest->userId,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}
