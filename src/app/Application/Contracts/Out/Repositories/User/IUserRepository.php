<?php

namespace App\Application\Contracts\Out\Repositories\User;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Auth\RegisterDto;
use App\Application\DTO\In\User\ChangeUserDataDto;
use App\Application\DTO\In\User\GetUsersDto;
use App\Application\DTO\Out\User\UserDto;

interface IUserRepository
{

    /**
     * @param GetUsersDto $getUsersDto
     * @return CursorDto
     */
    public function getAll(GetUsersDto $getUsersDto): CursorDto;

    /**
     * @param int $id
     * @return UserDto
     */
    public function findById(int $id): UserDto;

    /**
     * @param string $email
     * @return UserDto
     */
    public function findByEmail(string $email): UserDto;

    /**
     * @param RegisterDto $registerDto
     * @return UserDto
     */
    public function create(RegisterDto $userDto): UserDto;

    /**
     * @param ChangeUserDataDto $userDto
     * @return UserDto
     */
    public function update(ChangeUserDataDto $changeUserDataDto): UserDto;

    /**
     * @param int $userId
     * @param string $path
     * @return UserDto
     */
    public function updateAvatar(int $userId, string $path): UserDto;

    /**
     * @param int $userId
     * @param string $password
     * @return UserDto
     */
    public function updatePassword(int $userId, string $password): UserDto;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
