<?php

namespace App\Utils\Mappers\In\User;

use App\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Infrastructure\Http\Requests\User\ChangeUserAvatarRequest;

class ChangeUserAvatarDtoMapper
{

    /**
     * @param ChangeUserAvatarRequest $changeUserAvatarRequest
     * @return ChangeUserAvatarDto
     */
    public static function fromRequest(ChangeUserAvatarRequest $changeUserAvatarRequest): ChangeUserAvatarDto
    {
        return new ChangeUserAvatarDto(
            userId: (int)$changeUserAvatarRequest->route('userId'),
            avatar: $changeUserAvatarRequest->file('avatar')
        );
    }
}