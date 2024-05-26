<?php

namespace App\Application\Exceptions\Chat;

use App\Application\Exceptions\InternalException;

class ChatNotFound extends InternalException
{
    protected $code = 404;
    protected $message = "Не удалось найти чат";
}