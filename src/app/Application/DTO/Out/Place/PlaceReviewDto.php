<?php

namespace App\Application\DTO\Out\Place;

use App\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\PlaceReview;
use Carbon\Carbon;

class PlaceReviewDto
{
    public readonly string $id;
    public readonly string $text;
    public readonly float $rating;
    public readonly ?Carbon $created_at;
    public readonly UserDto $author;

    public function __construct(
        string $id,
        string $text,
        float $rating,
        ?Carbon $created_at,
        UserDto $author,
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
            author: UserDto::fromUserModel($review->author),
        );
    }

}
