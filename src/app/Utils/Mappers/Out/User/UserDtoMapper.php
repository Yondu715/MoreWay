<?php

namespace App\Utils\Mappers\Out\User;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\Out\User\UserDto;
use App\Infrastructure\Database\Models\ChatMember;
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
     * @param Collection<int, User> $users
     * @return Collection<int, UserDto>
     */
    public static function fromChatMemberCollection(Collection $users): Collection
    {
        return $users->map(function (ChatMember $user) {
            return self::fromUserModelToNotify($user->user);
        });
    }

    /**
     * @param User $user
     * @return UserDto
     */
    public static function fromUserModelToNotify(User $user): UserDto
    {
        return new UserDto(
            id: $user->id,
            name: $user->name,
            avatar: $user->avatar,
            email: $user->email
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
