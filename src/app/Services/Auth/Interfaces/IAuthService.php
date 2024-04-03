<?php

namespace App\Services\Auth\Interfaces;

use App\DTO\In\Auth\LoginDto;
use App\DTO\In\Auth\Password\ForgotPasswordDto;
use App\DTO\In\Auth\Password\ResetPasswordDto;
use App\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\DTO\In\Auth\RegisterDto;
use App\DTO\Out\Auth\UserDto;
use App\Exceptions\Auth\InvalidPassword;
use App\Exceptions\Auth\Password\ExpiredResetPasswordToken;
use App\Exceptions\Auth\Password\ExpiredVerifyPasswordCode;
use App\Exceptions\Auth\Password\InvalidResetPasswordToken;
use App\Exceptions\Auth\Password\InvalidVerifyPasswordCode;
use App\Exceptions\Auth\RegistrationConflict;
use App\Exceptions\User\UserNotFound;
use Exception;

interface IAuthService
{
    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws UserNotFound
     * @throws InvalidPassword
     */
    public function login(LoginDto $loginDto): string;

    /**
     * @param RegisterDto $registerDto
     * @return void
     * @throws RegistrationConflict
     */
    public function register(RegisterDto $registerDto): void;

    /**
     * @return UserDto
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

    /**
     * @param ForgotPasswordDto $forgotPasswordDto
     * @return void
     * @throws UserNotFound
     */
    public function forgotPassword(ForgotPasswordDto $forgotPasswordDto): void;

    /**
     * @param VerifyPasswordCodeDto $verifyPasswordCodeDto
     * @return string
     * @throws UserNotFound
     * @throws ExpiredVerifyPasswordCode
     * @throws InvalidVerifyPasswordCode
     */
    public function verifyPasswordCode(VerifyPasswordCodeDto $verifyPasswordCodeDto): string;

    /**
     * @param ResetPasswordDto $resetPasswordDto
     * @return void
     * @throws UserNotFound
     * @throws InvalidResetPasswordToken
     * @throws ExpiredResetPasswordToken
     */
    public function resetPassword(ResetPasswordDto $resetPasswordDto): void;
}
