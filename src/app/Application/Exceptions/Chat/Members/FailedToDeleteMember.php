<?php

namespace App\Application\Exceptions\Chat\Members;

use App\Application\Exceptions\InternalException;

class FailedToDeleteMember extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось удалить пользователя.";
}
