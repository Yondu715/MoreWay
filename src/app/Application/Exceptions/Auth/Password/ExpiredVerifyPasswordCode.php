<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Auth\Password;

use Exception;

class ExpiredVerifyPasswordCode extends Exception
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Срок действия кода для восстановления пароля истек";
}
