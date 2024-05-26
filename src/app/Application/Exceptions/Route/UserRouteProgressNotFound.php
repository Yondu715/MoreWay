<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class UserRouteProgressNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Точка прогресса не была найдена";
}
