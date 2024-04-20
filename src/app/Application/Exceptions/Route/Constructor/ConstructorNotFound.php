<?php

namespace App\Application\Exceptions\Route\Constructor;

use Exception;

class ConstructorNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Конструктор не был найден";
}
