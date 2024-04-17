<?php

namespace App\Application\DTO\In\User;

class ChangeUserPasswordDto
{
    public readonly int $userId;
    public readonly string $oldPassword;
    public readonly string $newPassword;

    public function __construct(
        string $oldPassword,
        string $newPassword,
        int $userId
    ) {
        $this->oldPassword = $oldPassword;
        $this->newPassword = $newPassword;
        $this->userId = $userId;
    }

}
