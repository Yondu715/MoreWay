<?php

namespace App\Dto;

use App\Http\Requests\ChangeUserAvatarRequest;
use Illuminate\Http\UploadedFile;

class ChangeUserAvatarDto
{
    public readonly int $userId;
    public readonly UploadedFile $avatar;

    public static function fromRequest(ChangeUserAvatarRequest $changeUserAvatarRequest): self
    {
        $dto = new self();

        $dto->userId = (int) $changeUserAvatarRequest->route('userId');
        $dto->avatar = $changeUserAvatarRequest->file('avatar');

        return $dto;
    }
}
