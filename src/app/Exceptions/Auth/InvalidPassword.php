<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class InvalidPassword extends BaseException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Неверный пароль";
}
