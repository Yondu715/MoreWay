<?php

namespace App\Services\Auth\Interfaces;

use App\DTO\In\Auth\LoginDto;
use App\DTO\In\Auth\RegisterDto;
use App\DTO\Out\Auth\UserDto;
use Exception;

interface IAuthService
{
    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws Exception
     */
    public function login(LoginDto $loginDto): string;

    /**
     * @param RegisterDto $registerDto
     * @return void
     * @throws Exception
     */
    public function register(RegisterDto $registerDto): void;

    /**
     * @return UserDto
     * @throws Exception
     */
    public function getAuthUser(): UserDto;

    /**
     * @return void
     */
    public function logout(): void;

    /**
     * @return string
     */
    public function refresh(): string;
}
