<?php

namespace App\Application\Exceptions\Chat\Members;

use Exception;

class UserIsNotCreator extends Exception
{
    protected $code = 403;
    protected $message = "Данный пользователь не является создателем чата";
}