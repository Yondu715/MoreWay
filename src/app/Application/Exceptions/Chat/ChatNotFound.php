<?php

namespace App\Application\Exceptions\Chat;

use Exception;

class ChatNotFound extends Exception
{
    protected $code = 404;
    protected $message = "Не удалось найти чат";
}