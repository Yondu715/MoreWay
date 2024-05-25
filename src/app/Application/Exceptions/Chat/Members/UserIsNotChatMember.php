<?php

namespace App\Application\Exceptions\Chat\Members;

use Exception;

class UserIsNotChatMember extends Exception
{
    protected $code = 403;
    protected $message = "Данный пользователь не является участником чата";
}