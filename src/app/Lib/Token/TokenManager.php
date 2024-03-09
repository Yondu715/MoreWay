<?php

namespace App\Lib\Token;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Logging\Exception;
use Tymon\JWTAuth\JWTGuard;

class TokenManager
{
    /**
     * @param User $user
     * @return string
     */
    static public function getNewToken(User $user): string
    {
        return self::getAuth()->login($user);
    }

    /**
     * @return string
     */
    static public function refreshToken(): string
    {
        $auth = self::getAuth();
        return $auth->refresh();
    }

    static public function destroyToken(): void
    {
        self::getAuth()->logout();
    }

    /**
     * @return User
     */
    static public function getAuthUser(): User
    {
        /**@var ?User $user */
        $user = self::getAuth()->user();

        if(!$user){
            throw new Exception();
        }
        return $user;
    }

    /**
     * @return JWTGuard
     */
    static private function getAuth(): JWTGuard
    {
        /** @var JWTGuard */
        return Auth::guard('api');
    }
}
