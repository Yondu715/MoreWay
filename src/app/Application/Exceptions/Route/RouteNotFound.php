<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class RouteNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Маршрут не был найден";
}
