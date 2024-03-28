<?php

namespace App\Exceptions\Auth\Password;

use App\Exceptions\BaseException;

class ExpiredResetPasswordToken extends BaseException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Срок действия токена для восстановления пароля истек";
}
