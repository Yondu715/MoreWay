<?php

namespace App\Application\Exceptions\Friend;

use Exception;

class FriendshipNotFound extends Exception
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = 'Не удалось найти отношения между пользователями';
}