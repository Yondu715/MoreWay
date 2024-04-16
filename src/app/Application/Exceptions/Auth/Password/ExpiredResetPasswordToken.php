<?php

namespace App\Application\Exceptions\Auth\Password;

use Exception;

class ExpiredResetPasswordToken extends Exception
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Срок действия токена для восстановления пароля истек";
}
