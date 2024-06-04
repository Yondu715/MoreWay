<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class MissingCountItems extends InternalException
{
    protected $code = 400;

    protected $message = "Недостаточное количество элементов";
}