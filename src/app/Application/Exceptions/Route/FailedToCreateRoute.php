<?php

namespace App\Application\Exceptions\Route;

use Exception;

class FailedToCreateRoute extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось создать маршрут";
}
