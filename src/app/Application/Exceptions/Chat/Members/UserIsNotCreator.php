<?php

namespace App\Application\Exceptions\Chat\Members;

use App\Application\Exceptions\InternalException;

class UserIsNotCreator extends InternalException
{
    protected $code = 403;
    protected $message = "Данный пользователь не является создателем чата";
}