<?php

namespace App\Application\Exceptions\Route;

use Exception;

class IncorrectOrderRoutePoints extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный порядок точек маршрута";
}
