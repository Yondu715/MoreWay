<?php

namespace App\Application\DTO\In\Chat\Activity;

class ChangeActivityDto
{
    public readonly int $chatId;
    public readonly int $routeId;

    public function __construct(
        int $chatId,
        int $routeId,
    ) {
        $this->chatId = $chatId;
        $this->routeId = $routeId;
    }
}
