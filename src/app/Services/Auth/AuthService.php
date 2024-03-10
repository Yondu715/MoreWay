<?php

namespace App\Services\Auth;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Exceptions\Auth\InvalidPassword;
use App\Exceptions\Auth\RegistrationConflict;
use App\Exceptions\User\UserNotFound;
use App\Lib\Token\TokenManager;
use App\Models\User;
use App\Services\Auth\DTO\UserDto;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function __construct(
        private readonly TokenManager $tokenManager
    ) {
    }
    /**
     * @param LoginDto $loginDto
     * @return string
     * @throws Exception
     */
    public function login(LoginDto $loginDto): string
    {
        /**@var User $user */
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
}
