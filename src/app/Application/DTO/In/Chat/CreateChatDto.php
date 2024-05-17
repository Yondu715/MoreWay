<?php

namespace App\Application\DTO\In\Chat;

class CreateChatDto
{
    public readonly string $name;
    public readonly int $creatorId;
    public readonly int $routeId;
    public readonly array $members;

    public function __construct(
        string $name,
        int $creatorId,
        int $routeId,
        array $members
    ) {
        $this->name = $name;
        $this->creatorId = $creatorId;
        $this->routeId = $routeId;
        $this->members = $members;
    }
}
