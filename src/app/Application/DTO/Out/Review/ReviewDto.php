<?php

namespace App\Application\DTO\Out\Review;

use App\Application\DTO\Out\User\UserDto;

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
        string $createdAt,
        UserDto $author,
    ) {
        $this->id = $id;
        $this->text = $text;
        $this->rating = $rating;
        $this->createdAt = $createdAt;
        $this->author= $author;
    }
}
