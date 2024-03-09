<?php

namespace App\Lib\Token;

use Illuminate\Support\Facades\Auth;
use PHPUnit\Logging\Exception;
use Tymon\JWTAuth\JWTGuard;

class TokenManager
{
    /**
     * @param array{'email': string, 'password': string} $user
     * @return string
     */
    static public function getNewToken(array $user): string
    {
        $token = (string)self::getAuth()->attempt($user);
        if (!$token) {
            throw new Exception();
        }

        return $token;
    }

    /**
     * @return string
     */
    static public function refreshToken(): string
    {
        /** @var JWTGuard $auth */
        return self::getAuth()->refresh();
    }

    static public function destroyToken(): void
    {
        self::getAuth()->logout();
    }

    /**
     * @return int
     */
    static public function getAuthUserId(): int
    {
        $id = self::getAuth()->id();

        if(!$id){
            throw new Exception();
        }
        return self::getAuth()->id();
    }

    /**
     * @return JWTGuard
     */
    static private function getAuth(): JWTGuard
    {
        /** @var JWTGuard $auth */
        return Auth::guard('api');
    }
}
