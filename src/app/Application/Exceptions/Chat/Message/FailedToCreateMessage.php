<?php

namespace App\Application\Exceptions\Chat\Message;

use App\Application\Exceptions\InternalException;

class FailedToCreateMessage extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось отправить сообщение";
}
