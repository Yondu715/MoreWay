<?php

namespace App\Infrastructure\Exceptions;

class RefreshTokenExpired extends ApiException
{
    /** @var int */
    protected $code = 401;

    /** @var string */
    protected $message = 'Истек срок жизни refresh токена';
}
