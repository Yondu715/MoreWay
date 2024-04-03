<?php

namespace App\DTO\Out\PlaceReview;

use App\Models\PlaceReview;
use App\Models\User;
use Carbon\Carbon;

class PlaceReviewDto
{
    public readonly string $id;
    public readonly string $text;
    public readonly float $rating;
    public readonly ?Carbon $created_at;
    public readonly User $author;

    public function __construct(
        string $id,
        string $text,
        float $rating,
        ?Carbon $created_at,
        User $author,
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->rating = $rating;
        $this->created_at = $created_at;
        $this->author= $author;
    }

    /**
     * @param PlaceReview $review
     * @return self
     */
    public static function fromReviewModel(PlaceReview $review): self
    {
        return new self(
            id: $review->id,
            text: $review->text,
            rating: $review->rating,
            created_at: $review->created_at,
            author: $review->author,
        );
    }

}
