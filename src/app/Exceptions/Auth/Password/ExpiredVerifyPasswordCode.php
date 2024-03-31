<?php

namespace App\Exceptions\Auth\Password;

use App\Exceptions\BaseException;

class ExpiredVerifyPasswordCode extends BaseException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Срок действия кода для восстановления пароля истек";
}
