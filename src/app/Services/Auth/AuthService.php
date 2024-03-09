<?php

namespace App\Services\Auth;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Lib\Token\TokenManager;
use App\Models\User;
use App\Services\Auth\DTO\OutAuthDto;
use App\Services\Auth\DTO\UserDto;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param LoginDto $loginDto
     * @return OutAuthDto
     * @throws Exception
     */
    public function login(LoginDto $loginDto): OutAuthDto
    {
        /**@var User $user */
        $user = User::query()->where([
            'email' => $loginDto->email
        ])->first();
        if (!$user || !Hash::check($loginDto->password, $user->password)) {
            throw new Exception('Неправильный логин или пароль', 405);
        }

        $token = TokenManager::getNewToken($user);

        return OutAuthDto::fromArray(UserDto::fromUserModel($user), $token);
    }

    /**
     * @param RegisterDto $registerDto
     * @return OutAuthDto
     * @throws Exception
     */
    public function register(RegisterDto $registerDto): OutAuthDto
    {
        if (User::query()->where('email', $registerDto->email)->first()) {
            throw new Exception();
        }

        /** @var User $user */
        $user = User::query()->create([
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => $registerDto->password,
        ]);
        $token = TokenManager::getNewToken($user);

        return OutAuthDto::fromArray(UserDto::fromUserModel($user), $token);
    }

    /**
     * @return UserDto
     */
    public function getAuthUser(): UserDto
    {
        return UserDto::fromUserModel(TokenManager::getAuthUser());
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        TokenManager::destroyToken();
    }

    /**
     * @return string
     */
    public function refresh(): string
    {
        return TokenManager::refreshToken();
    }
}
