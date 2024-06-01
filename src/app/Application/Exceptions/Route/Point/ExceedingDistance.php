<?php

namespace App\Application\Exceptions\Route\Point;

use App\Application\Exceptions\InternalException;

class ExceedingDistance extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Дистанция превышена";
}
