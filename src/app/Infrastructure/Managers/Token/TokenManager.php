<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Token;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\In\Auth\LoginDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Auth\UserDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Database\Models\User;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions\InvalidToken;
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
        return $this->getAuth()->refresh();
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

        return UserDto::fromUserModel($user);
    }

    /**
     * @param string $token
     * @return ?UserDto
     * @throws InvalidToken
     */
    public function parseToken(string $token): ?UserDto
    {
        try {
            return UserDto::fromUserModel(
                $this->getAuth()->setToken($token)->user()
            );
        } catch (Exception $e) {
            throw new InvalidToken();
        }
    }

    /**
     * @param string $role
     * @return bool
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
        return Auth::guard('api');
    }
}
