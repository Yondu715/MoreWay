<?php

namespace App\Application\Exceptions\Chat;

use Exception;

class FailedToCreateChat extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось создать чат";
}
