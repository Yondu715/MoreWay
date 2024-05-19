<?php

namespace App\Application\Exceptions\Chat\Activity;

use Exception;

class FailedToChangeActivity  extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось изменить выбранный маршрут чата.";
}
