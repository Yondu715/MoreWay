<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;

class InvalidOldPassword extends BaseException
{
    /** @var int */
    protected $code = 405;

    /** @var string */
    protected $message = 'Неверный старый пароль';
}
