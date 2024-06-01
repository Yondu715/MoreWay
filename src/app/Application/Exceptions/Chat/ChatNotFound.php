<?php

namespace App\Application\Exceptions\Chat;

use App\Application\Exceptions\InternalException;

class ChatNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Не удалось найти чат";
}