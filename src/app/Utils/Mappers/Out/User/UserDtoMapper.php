<?php

namespace App\Utils\Mappers\Out\User;

use Illuminate\Support\Collection;
use App\Application\DTO\Out\User\UserDto;
use Illuminate\Pagination\CursorPaginator;
use App\Infrastructure\Database\Models\User;
use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Infrastructure\Database\Models\ChatMember;

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
            return self::fromUserModel($user->user);
        });
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
