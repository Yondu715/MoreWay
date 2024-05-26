<?php

namespace App\Application\Exceptions\Chat\Activity;

use App\Application\Exceptions\InternalException;

class FailedToChangeActivity  extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось изменить выбранный маршрут чата.";
}
