<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class RouteNameIsTaken extends InternalException
{
    /** @var int */
    protected $code = 409;

    /** @var string */
    protected $message = "Маршрут с таким названием уже существует";
}

