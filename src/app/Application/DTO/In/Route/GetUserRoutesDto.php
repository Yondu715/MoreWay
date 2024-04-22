<?php

namespace App\Application\DTO\In\Route;

class GetUserRoutesDto
{
    public readonly ?string $cursor;
    public readonly int $userId;
    public readonly ?int $limit;

    public function __construct(
        ?string $cursor,
        int $userId,
        ?int $limit
    ) {
        $this->cursor = $cursor;
        $this->userId = $userId;
        $this->limit = $limit;
    }
}
