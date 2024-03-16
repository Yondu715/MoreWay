<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class RegistrationConflict extends BaseException
{
    /** @var int */
    protected $code = 409;

    /** @var string */
    protected $message = "Пользователь с таким email уже зарегистрирован";
}
