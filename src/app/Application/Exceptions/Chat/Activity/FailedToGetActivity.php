<?php

namespace App\Application\Exceptions\Chat\Activity;

use Exception;

class FailedToGetActivity extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось получить выбранный маршрут чата.";
}
