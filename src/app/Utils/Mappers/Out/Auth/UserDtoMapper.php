<?php

namespace App\Utils\Mappers\Out\Auth;

use App\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\User;

class UserDtoMapper
{
    /**
     * @param User $user
     * @return UserDto
     */
    public static function fromUserModel(User $user): UserDto
    {
        return new UserDto(
            id: $user->id,
            name: $user->name,
            avatar: $user->avatar,
            email: $user->email
        );
    }
}