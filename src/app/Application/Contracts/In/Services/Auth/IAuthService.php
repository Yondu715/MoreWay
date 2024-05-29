<?php

namespace App\Application\Contracts\In\Services\Auth;

use App\Application\DTO\In\Auth\LoginDto;
use App\Application\DTO\In\Auth\RegisterDto;
use App\Application\Dto\Out\User\ExtendedUserDto;
use App\Application\Exceptions\User\UserNotFound;
use App\Application\Exceptions\Auth\InvalidPassword;
use App\Application\Exceptions\Auth\RegistrationConflict;
use App\Application\DTO\In\Auth\Password\ResetPasswordDto;
use App\Application\DTO\In\Auth\Password\ForgotPasswordDto;
use App\Application\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\Application\Exceptions\Auth\Password\ExpiredResetPasswordToken;
use App\Application\Exceptions\Auth\Password\ExpiredVerifyPasswordCode;
use App\Application\Exceptions\Auth\Password\InvalidResetPasswordToken;
use App\Application\Exceptions\Auth\Password\InvalidVerifyPasswordCode;

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
     * @return ExtendedUserDto
     */
    public function getAuthUser(): ExtendedUserDto;

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
