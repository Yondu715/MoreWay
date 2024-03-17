<?php

namespace App\DTO\In\Place;

use App\Http\Requests\Place\CreateReviewRequest;

class CreateReviewDto
{
    public readonly int $place_id;
    public readonly int $author_id;
    public readonly int $rating;
    public readonly ?string $text;

    public function __construct(
        int $place_id,
        int $author_id,
        int $rating,
        ?string $text
    ) {
        $this->place_id = $place_id;
        $this->author_id = $author_id;
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
            author_id: $createReviewRequest->author_id,
            rating: $createReviewRequest->rating,
            text: $createReviewRequest->text
        );
    }
}
