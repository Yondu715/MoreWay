<?php

namespace App\Application\Exceptions\Route\Constructor;

use App\Application\Exceptions\InternalException;

class ConstructorNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Конструктор не был найден";
}
