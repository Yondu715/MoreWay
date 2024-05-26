<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class FailedToCreateRoute extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось создать маршрут";
}
