<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class IncorrectOrderRoutePoints extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный порядок точек маршрута";
}
