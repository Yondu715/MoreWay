<?php

namespace App\Application\Exceptions\User;

use App\Application\Exceptions\InternalException;

class UserNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Пользователь не был найден";
}
