<?php

namespace App\Infrastructure\Exceptions;

class RefreshTokenExpired extends ApiException
{
    protected $code = 401;
    protected $message = 'Истек срок жизни refresh токена';
}
