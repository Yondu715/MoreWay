<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class InvalidToken extends BaseException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Невалидный токен";
}
