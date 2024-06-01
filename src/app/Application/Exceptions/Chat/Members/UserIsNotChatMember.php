<?php

namespace App\Application\Exceptions\Chat\Members;

use App\Application\Exceptions\InternalException;

class UserIsNotChatMember extends InternalException
{
    /** @var int */
    protected $code = 403;

    /** @var string */
    protected $message = "Данный пользователь не является участником чата";
}