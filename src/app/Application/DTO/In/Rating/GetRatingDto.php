<?php

namespace App\Application\DTO\In\Rating;

class GetRatingDto
{
    public readonly ?string $cursor;
    public readonly ?int $limit;

    public function __construct(
        ?string $cursor,
        ?int $limit
    ) {
        $this->cursor = $cursor;
        $this->limit = $limit;
    }
}
