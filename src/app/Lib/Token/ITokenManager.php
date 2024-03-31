<?php

namespace App\Lib\Token;

use App\Models\User;

interface ITokenManager
{
    /**
     * @param User $user
     * @return string
     */
    public function createToken(User $user): string;

    /**
     * @return string
     */
    public function refreshToken(): string;

    /**
     * @return void
     */
    public function destroyToken(): void;

    /**
     * @return User
     * @throws Exception
     */
    public function getAuthUser(): User;
}