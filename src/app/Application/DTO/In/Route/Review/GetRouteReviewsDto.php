<?php

namespace App\Application\DTO\In\Route\Review;

class GetRouteReviewsDto
{
    public readonly int $routeId;
    public readonly ?string $cursor;
    public readonly int $limit;

    public function __construct(
        int $routeId,
        ?string $cursor,
        int $limit
    ) {
        $this->routeId = $routeId;
        $this->cursor = $cursor;
        $this->limit = $limit;
    }
}
