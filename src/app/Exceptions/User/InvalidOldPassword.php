<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;

class InvalidOldPassword extends BaseException
{
    protected $code = 405;
    protected $message = 'Неверный старый пароль';
}