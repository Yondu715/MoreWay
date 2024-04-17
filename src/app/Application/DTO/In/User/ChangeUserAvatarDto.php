<?php

namespace App\Application\DTO\In\User;

use Illuminate\Http\UploadedFile;

class ChangeUserAvatarDto
{
    public readonly int $userId;
    public readonly UploadedFile $avatar;

    public function __construct(
        int $userId,
        UploadedFile $avatar
    ) {
        $this->userId = $userId;
        $this->avatar = $avatar;
    }

}
