<?php

namespace App\Application\Exceptions\Auth\Password;

use App\Application\Exceptions\InternalException;

class ExpiredResetPasswordToken extends InternalException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Срок действия токена для восстановления пароля истек";
}
