<?php

namespace App\Application\Exceptions\Route\Constructor;

use Exception;

class InvalidRoutePointIndex extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Неверный индекс точки маршрута. Индекс должен быть инкрементным и начинаться с 1.";
}
