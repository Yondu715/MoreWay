<?php

namespace App\Application\Contracts\Out\Managers\Token;

use App\Application\DTO\In\Auth\LoginDto;
use App\Application\DTO\Out\User\UserDto;
use App\Infrastructure\Exceptions\InvalidToken;

interface ITokenManager
{
    /**
     * @param LoginDto $userDto
     * @return string
     */
    public function createToken(LoginDto $userDto): string;

    /**
     * @return string
     */
    public function refreshToken(): string;

    /**
     * @return void
     */
    public function destroyToken(): void;

    /**
     * @return UserDto
     * @throws InvalidToken
     */
    public function getAuthUser(): UserDto;

    /**
     * @param string $role
     * @return bool
     * @throws InvalidToken
     */
    public function hasRole(string $role): bool;

    /**
     * @param string $token
     * @return ?UserDto
     * @throws InvalidToken
     */
    public function parseToken(string $token): ?UserDto;
}
