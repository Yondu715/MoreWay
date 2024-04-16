<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Auth;

use Exception;

class InvalidPassword extends Exception
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Неверный пароль";
}
