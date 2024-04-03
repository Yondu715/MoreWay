<?php

namespace App\Lib\Token\Interfaces;

use App\Lib\Token\Exception;
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
