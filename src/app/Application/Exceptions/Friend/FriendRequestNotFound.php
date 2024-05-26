<?php

namespace App\Application\Exceptions\Friend;

use App\Application\Exceptions\InternalException;

class FriendRequestNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = "Запрос на дружбу не был найден";
}
