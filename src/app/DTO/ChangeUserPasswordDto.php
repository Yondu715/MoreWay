<?php

namespace App\Dto;

use App\Http\Requests\ChangeUserPasswordRequest;

class ChangeUserPasswordDto
{
    public readonly int $userId;
    public readonly string $oldPassword;
    public readonly string $newPassword;

    public static function fromRequest(ChangeUserPasswordRequest $changeUserPasswordRequest): self
    {
        $dto = new self();

        $dto->userId = (int) $changeUserPasswordRequest->route('userId');
        $dto->oldPassword = $changeUserPasswordRequest->oldPassword;
        $dto->newPassword = $changeUserPasswordRequest->newPassword;
        return $dto;
    }
}
