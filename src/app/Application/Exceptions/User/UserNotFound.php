<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\User;

use Exception;

class UserNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Пользователь не был найден";
}
