<?php

namespace App\Infrastructure\Managers\Token;

use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\DTO\In\Auth\LoginDto;
use App\Application\DTO\Out\User\UserDto;
use App\Infrastructure\Database\Models\User;
use App\Infrastructure\Enums\Auth\AuthGuard;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Infrastructure\Exceptions\RefreshTokenExpired;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTGuard;

class TokenManager implements ITokenManager
{
    /**
     * @param LoginDto $userDto
     * @return string
     */
    public function createToken(LoginDto $userDto): string
    {
        return $this->getAuth()->attempt([
            'email' => $userDto->email,
            'password' => $userDto->password
        ]);
    }

    /**
     * @return string
     */
    public function refreshToken(): string
    {
        try {
            return $this->getAuth()->refresh();
        } catch (\Throwable) {
            throw new RefreshTokenExpired();
        }
    }

    /**
     * @return void
     */
    public function destroyToken(): void
    {
        $this->getAuth()->logout();
    }

    /**
     * @return UserDto
     * @throws Exception
     */
    public function getAuthUser(): UserDto
    {
        /** @var ?User $user */
        $user = $this->getAuth()->user();

        if (!$user) {
            throw new InvalidToken();
        }

        return UserDtoMapper::fromUserModel($user);
    }

    /**
     * @param string $token
     * @return ?UserDto
     * @throws InvalidToken
     */
    public function parseToken(string $token): ?UserDto
    {
        try {
            /** @var ?User $user */
            $user = $this->getAuth()->setToken($token)->user();
            return UserDtoMapper::fromUserModel($user);
        } catch (Exception) {
            throw new InvalidToken();
        }
    }

    /**
     * @param string $role
     * @return bool
     * @throws InvalidToken
     */
    public function hasRole(string $role): bool
    {
        /** @var ?User $user */
        $user = $this->getAuth()->user();
        if (!$user) {
            throw new InvalidToken();
        }
        return $user->hasRole($role);
    }

    /**
     * @return JWTGuard
     */
    private function getAuth(): JWTGuard
    {
        /** @var JWTGuard */
        return Auth::guard(AuthGuard::API);
    }
}
