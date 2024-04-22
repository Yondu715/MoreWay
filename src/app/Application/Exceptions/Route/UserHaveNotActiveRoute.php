<?php

namespace App\Application\Exceptions\Route;

use Exception;

class UserHaveNotActiveRoute  extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Активный маршрут не найден";
}
