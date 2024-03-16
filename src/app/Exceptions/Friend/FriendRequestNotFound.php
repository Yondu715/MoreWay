<?php

namespace App\Exceptions\Friend;

use Exception;

class FriendRequestNotFound extends Exception
{
    protected $code = 404;
    protected $message = "Запрос на дружбу не был найден";
}
