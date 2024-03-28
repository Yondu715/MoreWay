<?php

namespace App\Services\Auth;

use App\DTO\In\Auth\ForgotPasswordDto;
use App\DTO\In\Auth\LoginDto;
use App\DTO\In\Auth\RegisterDto;
use App\DTO\Out\Auth\UserDto;
use App\Exceptions\Auth\InvalidPassword;
use App\Exceptions\Auth\RegistrationConflict;
use App\Exceptions\User\UserNotFound;
use App\Lib\Cache\CacheManager;
use App\Lib\Mail\MailManager;
use App\Lib\Token\TokenManager;
use App\Models\User;
use App\Services\Auth\Interfaces\IAuthService;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService implements IAuthService
{

    public function __construct(
        private readonly TokenManager $tokenManager,
        private readonly CacheManager $cacheManager,
        private readonly MailManager $mailManager
    ) {
    }
    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws Exception
     */
    public function login(LoginDto $loginDto): string
    {
        /**@var ?User $user */
        $user = User::query()->where([
            'email' => $loginDto->email
        ])->first();

        if (!$user) {
            throw new UserNotFound();
        }
        elseif (!Hash::check($loginDto->password, $user->password)){
            throw new InvalidPassword();
        }

        return $this->tokenManager->getNewToken($user);
    }

    /**
     * @param RegisterDto $registerDto
     * @return void
     * @throws Exception
     */
    public function register(RegisterDto $registerDto): void
    {
        if (User::query()->where('email', $registerDto->email)->first()) {
            throw new RegistrationConflict();
        }

        User::query()->create([
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => $registerDto->password,
        ]);
    }

    /**
     * @return UserDto
     * @throws Exception
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
        $user = User::query()->where('email', $forgotPasswordDto->email)->first();

        if (!$user) {
            throw new UserNotFound();
        }

        $resetCode = str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);

        $this->cacheManager->put('password_reset_' . $forgotPasswordDto->email,
            $resetCode);

        $this->mailManager->send($forgotPasswordDto->email, $resetCode);
    }
}
