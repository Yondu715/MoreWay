<?php

namespace App\Lib\Token;

use App\Exceptions\Auth\InvalidToken;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\JWTGuard;

class TokenManager implements ITokenManager
{
    /**
     * @param User $user
     * @return string
     */
    public function createToken(User $user): string
    {
        return self::getAuth()->login($user);
    }

    /**
     * @return string
     */
    public function refreshToken(): string
    {
        return self::getAuth()->refresh();
    }

    /**
     * @return void
     */
    public function destroyToken(): void
    {
        self::getAuth()->logout();
    }

    /**
     * @return User
     * @throws Exception
     */
    public function getAuthUser(): User
    {
        /** @var ?User $user */
        $user = self::getAuth()->user();

        if (!$user) {
            throw new InvalidToken();
        }

        return $user;
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
