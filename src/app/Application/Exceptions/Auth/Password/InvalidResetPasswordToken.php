<?php

namespace App\Application\Exceptions\Auth\Password;

use App\Application\Exceptions\InternalException;

class InvalidResetPasswordToken extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный токен для восстановления пароля";
}
