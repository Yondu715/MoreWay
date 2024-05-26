<?php

namespace App\Application\Exceptions\Auth;

use App\Application\Exceptions\InternalException;

class InvalidPassword extends InternalException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Неверный пароль";
}
