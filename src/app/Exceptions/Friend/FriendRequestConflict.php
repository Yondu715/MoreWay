<?php

namespace App\Exceptions\Friend;

use Exception;

class FriendRequestConflict extends Exception
{
    protected $code = 409;
    protected $message = "Запрос на дружбу уже был отправлен или пользователи уже являются друзьями";
}
