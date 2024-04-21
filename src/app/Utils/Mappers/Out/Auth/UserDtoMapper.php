<?php

namespace App\Utils\Mappers\Out\Auth;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\User;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Support\Collection;

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
            email: $user->email,
            password: $user->password
        );
    }

    /**
     * @param CursorPaginator $cursorPaginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $cursorPaginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($cursorPaginator, function (User $user) {
            return self::fromUserModel($user);
        });
    }
}