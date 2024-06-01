<?php

namespace App\Application\Exceptions\Chat;

use App\Application\Exceptions\InternalException;

class FailedToCreateChat extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось создать чат";
}
