<?php

namespace App\Application\DTO\In\User;

class ChangeUserDataDto
{
    public readonly int $userId;
    public readonly ?string $name;

    public function __construct(
        int $userId,
        ?string $name
    ) {
        $this->userId = $userId;
        $this->name = $name;
    }
}
