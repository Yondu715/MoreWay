<?php

namespace App\Application\Exceptions\Chat\Message;

use Exception;

class FailedToCreateMessage extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось отправить сообщение";
}
