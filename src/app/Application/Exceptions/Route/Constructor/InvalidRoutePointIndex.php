<?php

namespace App\Application\Exceptions\Route\Constructor;

use App\Application\Exceptions\InternalException;

class InvalidRoutePointIndex extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный индекс точки маршрута. Индекс должен быть инкрементным и начинаться с 1";
}
