<?php

namespace App\Utils\Mappers\In\User;

use App\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Infrastructure\Http\Requests\User\ChangeUserPasswordRequest;

class ChangeUserPasswordDtoMapper
{
    /**
     * @param ChangeUserPasswordRequest $changeUserPasswordRequest
     * @return ChangeUserPasswordDto
     */
    public static function fromRequest(ChangeUserPasswordRequest $changeUserPasswordRequest): ChangeUserPasswordDto
    {
        return new ChangeUserPasswordDto(
            oldPassword: $changeUserPasswordRequest->oldPassword,
            newPassword: $changeUserPasswordRequest->newPassword,
            userId: (int)$changeUserPasswordRequest->route('userId')
        );
    }
}