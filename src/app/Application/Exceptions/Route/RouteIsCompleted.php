<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class RouteIsCompleted extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Маршрут уже был пройден ранее";
}
