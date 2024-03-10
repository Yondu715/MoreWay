<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class RegistrationConflict extends BaseException
{
    protected $code = 409;
    protected $message = "Пользователь с таким email уже зарегистрирован";
}
