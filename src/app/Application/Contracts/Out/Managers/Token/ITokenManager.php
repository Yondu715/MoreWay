<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Token;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\LoginDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions\InvalidToken;

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
