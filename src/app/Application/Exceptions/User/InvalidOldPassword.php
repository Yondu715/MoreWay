<?php

namespace App\Application\Exceptions\User;

use Exception;

class InvalidOldPassword extends Exception
{
    /** @var int */
    protected $code = 405;

    /** @var string */
    protected $message = 'Неверный старый пароль';
}
