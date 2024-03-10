<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class InvalidToken extends BaseException
{
    protected $code = 401;
    protected $message = "Невалидный токен";
}
