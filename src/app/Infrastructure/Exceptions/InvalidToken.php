<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions;

class InvalidToken extends ApiException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = "Невалидный токен";
}
