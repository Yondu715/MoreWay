<?php

namespace App\Application\Exceptions\User;

use App\Application\Exceptions\InternalException;

class InvalidOldPassword extends InternalException
{
    /** @var int */
    protected $code = 405;

    /** @var string */
    protected $message = 'Неверный старый пароль';
}
