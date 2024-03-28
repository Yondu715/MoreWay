<?php

namespace App\Exceptions\Place;

use App\Exceptions\BaseException;

class PlaceNotFound extends BaseException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Достопримечательность не была найдена";
}
