<?php

namespace App\Application\Exceptions\Chat\Members;

use Exception;

class FailedToDeleteMember extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось удаить пользователя";
}
