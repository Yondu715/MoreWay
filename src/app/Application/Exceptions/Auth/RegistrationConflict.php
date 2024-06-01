<?php

namespace App\Application\Exceptions\Auth;

use App\Application\Exceptions\InternalException;

class RegistrationConflict extends InternalException
{
    /** @var int */
    protected $code = 409;

    /** @var string */
    protected $message = "Пользователь с таким email уже существует";
}
