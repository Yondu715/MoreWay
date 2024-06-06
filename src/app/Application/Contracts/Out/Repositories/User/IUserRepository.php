<?php

namespace App\Application\Contracts\Out\Repositories\User;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Auth\RegisterDto;
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
     * @param RegisterDto $userDto
     * @return UserDto
     */
    public function create(RegisterDto $userDto): UserDto;

    /**
     * @param int $id
     * @param array $attributes
     * @return UserDto
     */
    public function update(int $id, array $attributes): UserDto;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteById(int $id): bool;

}
