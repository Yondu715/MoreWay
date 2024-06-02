<?php

namespace App\Application\Services\Auth;

use Exception;
use App\Application\DTO\In\Auth\LoginDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Enums\Auth\PasswordKey;
use App\Application\DTO\In\Auth\RegisterDto;
use App\Application\DTO\Out\User\ExtendedUserDto;
use App\Application\Exceptions\User\UserNotFound;
use App\Application\Exceptions\Auth\InvalidPassword;
use App\Application\Exceptions\Auth\RegistrationConflict;
use App\Application\DTO\In\Auth\Password\ResetPasswordDto;
use App\Application\DTO\In\Auth\Password\ForgotPasswordDto;
use App\Application\Contracts\In\Services\Auth\IAuthService;
use App\Application\Contracts\Out\Managers\Hash\IHashManager;
use App\Application\Contracts\Out\Managers\Mail\IMailManager;
use App\Application\Contracts\Out\Managers\Cache\ICacheManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\DTO\In\Auth\Password\VerifyPasswordCodeDto;
use App\Application\Contracts\Out\Repositories\User\IUserRepository;
use App\Application\Exceptions\Auth\Password\ExpiredResetPasswordToken;
use App\Application\Exceptions\Auth\Password\ExpiredVerifyPasswordCode;
use App\Application\Exceptions\Auth\Password\InvalidResetPasswordToken;
use App\Application\Exceptions\Auth\Password\InvalidVerifyPasswordCode;
use Throwable;

class AuthService implements IAuthService
{

    public function __construct(
        private readonly IUserRepository $userRepository,
        private readonly ITokenManager $tokenManager,
        private readonly ICacheManager $cacheManager,
        private readonly IMailManager $mailManager,
        private readonly IHashManager $hashManager
    ) {
    }

    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws InvalidPassword
     */
    public function login(LoginDto $loginDto): string
    {
        $user = $this->userRepository->findByEmail($loginDto->email);

        if (!$this->hashManager->check($loginDto->password, $user->password)) {
            throw new InvalidPassword();
        }

        return $this->tokenManager->createToken($loginDto);
    }

    /**
     * @param RegisterDto $registerDto
     * @return UserDto
     * @throws RegistrationConflict
     */
    public function register(RegisterDto $registerDto): UserDto
    {
        try {
            $this->userRepository->findByEmail($registerDto->email);
        } catch (Throwable) {
            throw new RegistrationConflict();
        }

        return $this->userRepository->create($registerDto);
    }

    /**
     * @return ExtendedUserDto
     * @throws Exception
     */
    public function getAuthUser(): ExtendedUserDto
    {
        return $this->tokenManager->getAuthUser();
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->tokenManager->destroyToken();
    }

    /**
     * @return string
     */
    public function refresh(): string
    {
        return $this->tokenManager->refreshToken();
    }

    /**
     * @param ForgotPasswordDto $forgotPasswordDto
     * @return void
     */
    public function forgotPassword(ForgotPasswordDto $forgotPasswordDto): void
    {
        $user = $this->userRepository->findByEmail($forgotPasswordDto->email);

        $resetCode = str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);

        $this->cacheManager->put(
            PasswordKey::RESET_PASSWORD->value . '_' . $user->email,
            $resetCode,
            300
        );

        $this->mailManager->sendResetCode($user->email, $resetCode);
    }

    /**
     * @param VerifyPasswordCodeDto $verifyPasswordCodeDto
     * @return string
     * @throws ExpiredVerifyPasswordCode
     * @throws InvalidVerifyPasswordCode
     */
    public function verifyPasswordCode(VerifyPasswordCodeDto $verifyPasswordCodeDto): string
    {
        $user = $this->userRepository->findByEmail($verifyPasswordCodeDto->email);

        $resetCode = $this->cacheManager->get(PasswordKey::RESET_PASSWORD->value . '_' . $verifyPasswordCodeDto->email);

        if (!$resetCode) {
            throw new ExpiredVerifyPasswordCode();
        }

        if ($resetCode !== $verifyPasswordCodeDto->code) {
            throw new InvalidVerifyPasswordCode();
        }

        $resetToken = $this->hashManager->make($verifyPasswordCodeDto->code);
        $this->cacheManager->put(
            PasswordKey::RESET_PASSWORD->value . '_' . $user->email,
            $resetToken,
            300
        );
        return $resetToken;
    }

    /**
     * @param ResetPasswordDto $resetPasswordDto
     * @return void
     * @throws InvalidResetPasswordToken
     * @throws ExpiredResetPasswordToken
     */
    public function resetPassword(ResetPasswordDto $resetPasswordDto): void
    {
        $user = $this->userRepository->findByEmail($resetPasswordDto->email);

        $resetToken = $this->cacheManager->get(PasswordKey::RESET_PASSWORD->value . '_' . $user->email);

        if (!$resetToken) {
            throw new ExpiredResetPasswordToken();
        }
        if ($resetToken !== $resetPasswordDto->token) {
            throw new InvalidResetPasswordToken();
        }

        $this->userRepository->update($user->id, [
            'password' => $resetPasswordDto->password
        ]);
    }
}
