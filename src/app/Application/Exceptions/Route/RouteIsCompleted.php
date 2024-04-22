<?php

namespace App\Application\Exceptions\Route;

use Exception;

class RouteIsCompleted extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Маршрут уже был пройден ранее";
}
