<?php

namespace App\Application\Exceptions\Route;

use Exception;

class UserRouteProgressNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Точка прогресса не была найдена";
}
