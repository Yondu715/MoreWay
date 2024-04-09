<?php

namespace App\Application\Contracts\Out\Managers;

use App\Application\DTO\In\Auth\LoginDto;
use App\Infrastructure\Database\Models\User;
use Exception;

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
     * @return User
     * @throws Exception
     */
    public function getAuthUser(): User;

    /**
     * @param string $token
     * @return ?User
     */
    public function parseToken(string $token): ?User;
}
