<?php

namespace App\Exceptions\Auth\Password;

use App\Exceptions\BaseException;

class InvalidResetPasswordToken extends BaseException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный токен для восстановления пароля";
}
