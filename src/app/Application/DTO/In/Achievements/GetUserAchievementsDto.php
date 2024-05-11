<?php

namespace App\Application\DTO\In\Achievements;

class GetUserAchievementsDto
{
    public readonly int $userId;
    public readonly ?string $cursor;
    public readonly ?int $limit;

    public function __construct(
        int $userId,
        ?string $cursor,
        ?int $limit
    ) {
        $this->userId = $userId;
        $this->cursor = $cursor;
        $this->limit = $limit;
    }
}
