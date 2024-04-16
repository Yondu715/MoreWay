<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Auth\Password;

use Exception;

class InvalidResetPasswordToken extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный токен для восстановления пароля";
}
