<?php

namespace App\Exceptions\Auth\Password;

use App\Exceptions\BaseException;

class InvalidVerifyPasswordCode extends BaseException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Введенный код восстановления пароля неверен";
}
