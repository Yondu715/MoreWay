<?php

namespace App\Services\Auth;

use App\DTO\Auth\LoginDto;
use App\DTO\Auth\RegisterDto;
use App\Lib\Token\TokenManager;
use App\Models\User;
use App\Services\Auth\DTO\OutAuthDto;
use App\Services\Auth\DTO\UserDto;
use Exception;

class AuthService
{
    /**
     * @param LoginDto $loginDto
     * @return OutAuthDto
     */
    public function login(LoginDto $loginDto): OutAuthDto
    {
        $user = [
            'email' => $loginDto->email,
            'password' => $loginDto->password,
        ];

        $token = TokenManager::getNewToken($user);

        return OutAuthDto::fromArray($this->getAuthUser(),$token);
    }

    /**
     * @param RegisterDto $registerDto
     * @return OutAuthDto
     */
    public function register(RegisterDto $registerDto): OutAuthDto
    {
        if(User::query()->where('email', $registerDto->email)->first()){
            throw new Exception();
        }

        $user = [
            'name' => $registerDto->name,
            'email' => $registerDto->email,
            'password' => $registerDto->password,
        ];

        User::query()->create($user);

        $token = TokenManager::getNewToken([
            'email' => $registerDto->email,
            'password' => $registerDto->password,
        ]);

        return OutAuthDto::fromArray($this->getAuthUser(), $token);
    }

    /**
     * @return UserDto
     */
    public function getAuthUser(): UserDto
    {
        /**@var User $user*/
        $user = User::query()->find(TokenManager::getAuthUserId());

        return UserDto::fromUserModel($user);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return void
     */
    public function logout(): void
    {
        TokenManager::destroyToken();
    }

    /**
     * Refresh a token.
     *
     * @return string
     */
    public function refresh(): string
    {
        return TokenManager::refreshToken();
    }
}
