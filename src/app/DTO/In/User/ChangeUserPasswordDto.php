<?php

namespace App\DTO\In\User;

use App\Http\Requests\User\ChangeUserPasswordRequest;

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

    public static function fromRequest(ChangeUserPasswordRequest $changeUserPasswordRequest): self
    {
        return new self(
            oldPassword: $changeUserPasswordRequest->oldPassword,
            newPassword: $changeUserPasswordRequest->newPassword,
            userId: (int) $changeUserPasswordRequest->route('userId')
        );
    }
}
