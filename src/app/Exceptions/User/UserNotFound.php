<?php

namespace App\Exceptions\User;

use App\Exceptions\BaseException;

class UserNotFound extends BaseException
{
    protected $code = 404;
    protected $message = "Пользователь не был найден";
}
