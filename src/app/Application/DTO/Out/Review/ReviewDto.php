<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\PlaceReview;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ReviewDto
{
    public readonly int $id;
    public readonly ?string $text;
    public readonly float $rating;
    public readonly string $createdAt;
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
    public static function fromReviewModel(Model $review): self
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
