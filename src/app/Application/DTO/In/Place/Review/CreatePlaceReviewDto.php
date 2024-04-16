<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Place\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\Review\CreateReviewRequest;

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

    /**
     * @param CreateReviewRequest $createReviewRequest
     * @return self
     */
    public static function fromRequest(CreateReviewRequest $createReviewRequest): self
    {
        return new self(
            placeId: $createReviewRequest->route('placeId'),
            userId: $createReviewRequest->userId,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}
