<?php

namespace App\Application\Exceptions\Friend;

use Exception;

class FriendRequestNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Запрос на дружбу не был найден";
}
