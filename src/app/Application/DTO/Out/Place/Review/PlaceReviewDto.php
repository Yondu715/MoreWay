<?php

namespace App\Application\DTO\Out\Place\Review;

use App\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\PlaceReview;
use Carbon\Carbon;
use Illuminate\Pagination\CursorPaginator;

class PlaceReviewDto
{
    public readonly int $id;
    public readonly ?string $text;
    public readonly float $rating;
    public readonly string $created_at;
    public readonly UserDto $author;

    public function __construct(
        string $id,
        ?string $text,
        float $rating,
        string $created_at,
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
        $create_at = new Carbon($review->created_at);
        return new self(
            id: $review->id,
            text: $review->text,
            rating: $review->rating,
            created_at: (string)$create_at,
            author: UserDto::fromUserModel($review->author),
        );
    }
}
