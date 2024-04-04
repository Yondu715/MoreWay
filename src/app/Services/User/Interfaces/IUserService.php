<?php

namespace App\Services\User\Interfaces;

use App\DTO\In\User\ChangeUserAvatarDto;
use App\DTO\In\User\ChangeUserDataDto;
use App\DTO\In\User\ChangeUserPasswordDto;
use App\DTO\In\User\GetUsersDto;
use App\DTO\Out\Auth\UserDto;
use App\Exceptions\User\InvalidOldPassword;
use App\Exceptions\User\UserNotFound;
use App\Models\User;
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
     * @throws UserNotFound
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
