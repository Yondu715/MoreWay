<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class InvalidPassword extends BaseException
{
    protected $code = 401;
    protected $message = "Неверный пароль";
}
