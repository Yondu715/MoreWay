<?php

namespace App\Application\Exceptions\Place;

use App\Application\Exceptions\InternalException;

class PlaceNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Достопримечательность не была найдена";
}
