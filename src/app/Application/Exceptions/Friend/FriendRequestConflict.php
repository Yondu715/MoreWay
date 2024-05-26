<?php

namespace App\Application\Exceptions\Friend;

use App\Application\Exceptions\InternalException;

class FriendRequestConflict extends InternalException
{
    /** @var int */
    protected $code = 409;

    /** @var string */
    protected $message = "Невозможно создать запрос на дружбу";
}
