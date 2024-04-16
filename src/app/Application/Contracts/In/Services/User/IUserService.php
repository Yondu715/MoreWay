<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\In\Services\User;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\ChangeUserDataDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\User\GetUsersDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\User\InvalidOldPassword;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\User\UserNotFound;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\User;
use Illuminate\Support\Collection;

interface IUserService
{
    /**
     * @param GetUsersDto $getUsersDto
     * @return Collection<int,User>
     */
    public function getUsers(GetUsersDto $getUsersDto): Collection;

    /**
     * @param int $userId
     * @return UserDto
     * @throws UserNotFound
     */
    public function getUserById(int $userId): UserDto;

    /**
     * @param int $userId
     * @return bool
     */
    public function deleteUserById(int $userId): bool;

    /**
     * @param ChangeUserPasswordDto $changeUserPasswordDto
     * @return UserDto
     * @throws InvalidOldPassword
     * @throws UserNotFound
     */
    public function changePassword(ChangeUserPasswordDto $changeUserPasswordDto): UserDto;

    /**
     * @param ChangeUserAvatarDto $changeUserAvatarDto
     * @return UserDto
     * @throws UserNotFound
     */
    public function changeAvatar(ChangeUserAvatarDto $changeUserAvatarDto): UserDto;

    /**
     * @param ChangeUserDataDto $changeUserDataDto
     * @return UserDto
     * @throws UserNotFound
     */
    public function changeData(ChangeUserDataDto $changeUserDataDto): UserDto;

}
