<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Place;

use Exception;

class PlaceNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Достопримечательность не была найдена";
}
