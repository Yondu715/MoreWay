<?php

namespace App\Application\Exceptions\Auth\Password;

use App\Application\Exceptions\InternalException;

class ExpiredVerifyPasswordCode extends InternalException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Срок действия кода для восстановления пароля истек";
}
