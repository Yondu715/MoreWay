<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\ChangeUserPasswordRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Lib\HashId\HashManager;

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
            userId: $changeUserPasswordRequest->route('userId')
        );
    }
}
