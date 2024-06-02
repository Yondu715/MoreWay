<?php

namespace App\Application\Exceptions\Rating;

use App\Application\Exceptions\InternalException;

class RatingNotFound extends InternalException
{
    protected $code = 404;
    protected $message = "Рейтинг не был найден";
}