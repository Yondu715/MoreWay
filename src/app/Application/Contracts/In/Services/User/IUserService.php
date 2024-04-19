<?php

namespace App\Application\Contracts\In\Services\User;

use App\Application\DTO\In\User\ChangeUserAvatarDto;
use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Application\DTO\In\User\ChangeUserPasswordDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\DTO\Out\Auth\UserDto;
use App\Application\Exceptions\User\InvalidOldPassword;
use App\Application\Exceptions\User\UserNotFound;
use Illuminate\Support\Collection;

interface IUserService
{
    /**
     * @param GetUsersDto $getUsersDto
     * @return Collection<int,UserDto>
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
