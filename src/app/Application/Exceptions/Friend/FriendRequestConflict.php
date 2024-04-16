<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Friend;

use Exception;

class FriendRequestConflict extends Exception
{
    /** @var int */
    protected $code = 409;

    /** @var string */
    protected $message = "Невозможно создать запрос на дружбу";
}
