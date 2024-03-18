<?php

namespace App\DTO\In\Place;

use App\Http\Requests\Place\CreateReviewRequest;

class CreateReviewDto
{
    public readonly int $place_id;
    public readonly int $user_id;
    public readonly int $rating;
    public readonly ?string $text;

    public function __construct(
        int $place_id,
        int $user_id,
        int $rating,
        ?string $text
    ) {
        $this->place_id = $place_id;
        $this->user_id = $user_id;
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
            place_id: $createReviewRequest->route('placeId'),
            user_id: $createReviewRequest->user_id,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}
