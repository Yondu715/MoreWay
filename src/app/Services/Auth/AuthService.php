<?php

namespace App\Services\Auth;

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
use App\Lib\Cache\Interfaces\ICacheManager;
use App\Lib\Mail\Interfaces\IMailManager;
use App\Lib\Token\Interfaces\ITokenManager;
use App\Models\User;
use App\Repositories\User\Interfaces\IUserRepository;
use App\Services\Auth\Interfaces\IAuthService;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{

    public function __construct(
        private readonly ITokenManager $tokenManager,
        private readonly ICacheManager $cacheManager,
        private readonly IMailManager $mailManager,
        private readonly IUserRepository $userRepository
    ) {
    }

    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws UserNotFound
     * @throws InvalidPassword
     */
    public function login(LoginDto $loginDto): string
    {
        $user = $this->userRepository->findByEmail($loginDto->email);

        if (!$user) {
            throw new UserNotFound();
        }

        if (!Hash::check($loginDto->password, $user->password)) {
            throw new InvalidPassword();
        }

        return $this->tokenManager->createToken($user);
    }

    /**
     * @param RegisterDto $registerDto
     * @return void
     * @throws RegistrationConflict
     */
    public function register(RegisterDto $registerDto): void
    {
        if ($this->userRepository->findByEmail($registerDto->email)) {
            throw new RegistrationConflict();
        }

        $this->userRepository->create([
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => $registerDto->password
        ]);
    }

    /**
     * @return UserDto
     */
    public function getAuthUser(): UserDto
    {
        return UserDto::fromUserModel($this->tokenManager->getAuthUser());
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
     * @throws UserNotFound
     */
    public function forgotPassword(ForgotPasswordDto $forgotPasswordDto): void
    {
        $user = $this->userRepository->findByEmail($forgotPasswordDto->email);

        if (!$user) {
            throw new UserNotFound();
        }

        $resetCode = str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);

        $this->cacheManager->put(
            'password_reset_' . $forgotPasswordDto->email,
            $resetCode
        );

        $this->mailManager->sendResetCode($forgotPasswordDto->email, $resetCode);
    }

    /**
     * @param VerifyPasswordCodeDto $verifyPasswordCodeDto
     * @return string
     * @throws UserNotFound
     * @throws ExpiredVerifyPasswordCode
     * @throws InvalidVerifyPasswordCode
     */
    public function verifyPasswordCode(VerifyPasswordCodeDto $verifyPasswordCodeDto): string
    {
        /** @var ?User */
        $user = $this->userRepository->findByEmail($verifyPasswordCodeDto->email);

        if (!$user) {
            throw new UserNotFound();
        }

        $resetCode = $this->cacheManager->get('password_reset_' . $verifyPasswordCodeDto->email);

        if (!$resetCode) {
            throw new ExpiredVerifyPasswordCode();
        }

        if ($resetCode !== $verifyPasswordCodeDto->code) {
            throw new InvalidVerifyPasswordCode();
        }

        $resetToken = Hash::make($verifyPasswordCodeDto->code);
        $this->cacheManager->put(
            'password_reset_' . $verifyPasswordCodeDto->email,
            $resetToken
        );
        return $resetToken;
    }

    /**
     * @param ResetPasswordDto $resetPasswordDto
     * @return void
     * @throws UserNotFound
     * @throws InvalidResetPasswordToken
     * @throws ExpiredResetPasswordToken
     */
    public function resetPassword(ResetPasswordDto $resetPasswordDto): void
    {
        /** @var ?User $user */
        $user = $this->userRepository->findByEmail($resetPasswordDto->email);

        if (!$user) {
            throw new UserNotFound();
        }

        $resetToken = $this->cacheManager->get('password_reset_' . $resetPasswordDto->email);

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
