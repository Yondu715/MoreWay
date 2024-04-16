<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Requests\User\ChangeUserAvatarRequest;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Lib\HashId\HashManager;
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

    public static function fromRequest(ChangeUserAvatarRequest $changeUserAvatarRequest): self
    {
        return new self(
            userId: $changeUserAvatarRequest->route('userId'),
            avatar: $changeUserAvatarRequest->file('avatar')
        );
    }
}
