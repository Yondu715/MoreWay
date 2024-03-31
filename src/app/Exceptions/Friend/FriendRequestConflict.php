<?php

namespace App\Exceptions\Friend;

use Exception;

class FriendRequestConflict extends Exception
{
    /** @var int */
    protected $code = 409;
    
    /** @var string */
    protected $message = "Невозможно создать запрос на дружбу";
}
