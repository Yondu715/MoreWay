<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class UserHaveNotActiveRoute  extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Активный маршрут не найден";
}
