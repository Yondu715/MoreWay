<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;

class UserNotFound extends BaseException
{
    /** @var int */
    protected $code = 404;
    
    /** @var string */
    protected $message = "Пользователь не был найден";
}
