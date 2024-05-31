<?php

namespace App\Application\Exceptions\Route\Point;

use App\Application\Exceptions\InternalException;

class RoutePointNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Точка маршрута не была найдена";
}
