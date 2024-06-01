<?php

namespace App\Application\Exceptions\Chat\Members;

use App\Application\Exceptions\InternalException;

class UserIsNotCreator extends InternalException
{
    /** @var int */
    protected $code = 403;

    /** @var string */
    protected $message = "Данный пользователь не является создателем чата";
}