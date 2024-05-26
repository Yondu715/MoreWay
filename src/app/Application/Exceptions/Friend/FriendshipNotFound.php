<?php

namespace App\Application\Exceptions\Friend;

use App\Application\Exceptions\InternalException;

class FriendshipNotFound extends InternalException
{
    /** @var int */
    protected $code = 404;

    /** @var string */
    protected $message = 'Не удалось найти отношения между пользователями';
}