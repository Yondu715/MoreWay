<?php

namespace App\Application\Exceptions\Chat\Members;

use Exception;

class FailedToAddMembers extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось добавить пользователей в чат.";
}
