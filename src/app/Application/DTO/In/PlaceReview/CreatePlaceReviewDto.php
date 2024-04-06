<?php

namespace App\Application\DTO\In\PlaceReview;

use App\Infrastructure\Http\Requests\Place\PlaceReview\CreatePlaceReviewRequest;

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
     * @param CreatePlaceReviewRequest $createReviewRequest
     * @return self
     */
    public static function fromRequest(CreatePlaceReviewRequest $createReviewRequest): self
    {
        return new self(
            placeId: $createReviewRequest->route('placeId'),
            userId: $createReviewRequest->userId,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}
