<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Auth\Password;

use Exception;

class InvalidVerifyPasswordCode extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Введенный код восстановления пароля неверен";
}
