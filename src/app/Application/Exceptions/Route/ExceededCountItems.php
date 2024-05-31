<?php

namespace App\Application\Exceptions\Route;

use App\Application\Exceptions\InternalException;

class ExceededCountItems extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Превышено количество элементов";
}