<?php

namespace App\Application\Exceptions\Chat\Activity;

use App\Application\Exceptions\InternalException;

class FailedToGetActivity extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось получить выбранный маршрут чата";
}
