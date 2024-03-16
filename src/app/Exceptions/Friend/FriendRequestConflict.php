<?php

namespace App\Exceptions\Friend;

use Exception;

class FriendRequestConflict extends Exception
{
    /** @var int */
    protected $code = 409;
    
    /** @var string */
    protected $message = "Запрос на дружбу уже был отправлен или пользователи уже являются друзьями";
}
