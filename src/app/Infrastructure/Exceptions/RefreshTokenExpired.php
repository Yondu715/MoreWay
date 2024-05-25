<?php

namespace App\Infrastructure\Exceptions;

use Exception;

class RefreshTokenExpired extends Exception
{
    protected $code = 401;
    protected $message = 'Истек срок жизни refresh токена'
}