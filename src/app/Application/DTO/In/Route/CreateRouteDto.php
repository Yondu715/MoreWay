<?php

namespace App\Application\DTO\In\Route;

class CreateRouteDto
{
    public readonly int $userId;
    public readonly string $name;

    public function __construct(
        int $userId,
        string $name,
    ) {
        $this->userId = $userId;
        $this->name = $name;
    }
}
