<?php

namespace App\Application\Exceptions\Chat\Message;

use Exception;

class FailedToGetMessages extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось загрузить изображения";
}
