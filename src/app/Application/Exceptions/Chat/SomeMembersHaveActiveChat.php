<?php

namespace App\Application\Exceptions\Chat;

use App\Application\Exceptions\InternalException;

class SomeMembersHaveActiveChat extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "У некоторых пользователей уже есть активный машрут.";
}
