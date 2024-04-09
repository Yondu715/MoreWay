<?php

namespace App\Infrastructure\Managers\Token;

use App\Application\Contracts\Out\Managers\ITokenManager;
use App\Application\DTO\In\Auth\LoginDto;
use App\Infrastructure\Database\Models\User;
use App\Infrastructure\Exceptions\InvalidToken;
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
     * @return User
     * @throws Exception
     */
    public function getAuthUser(): User
    {
        /** @var ?User $user */
        $user = $this->getAuth()->user();

        if (!$user) {
            throw new InvalidToken();
        }

        return $user;
    }

    /**
     * @param string $token
     * @return ?User
     * @throws InvalidToken
     */
    public function parseToken(string $token): ?User
    {
        try {
            return $this->getAuth()->setToken($token)->user();
        } catch (Exception $e) {
            throw new InvalidToken();
        }
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
