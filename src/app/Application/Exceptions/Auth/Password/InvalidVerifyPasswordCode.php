<?php

namespace App\Application\Exceptions\Auth\Password;

use App\Application\Exceptions\InternalException;

class InvalidVerifyPasswordCode extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный код для восстановления пароля";
}
