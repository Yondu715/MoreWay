<?php

namespace App\Application\Exceptions\Auth\Password;

use Exception;

class InvalidVerifyPasswordCode extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный код для восстановления пароля";
}
