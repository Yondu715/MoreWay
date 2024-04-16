<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Route;

use Exception;

class RouteNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Маршрут не был найден";
}
