<?php

namespace App\Application\Exceptions\Chat;

use App\Application\Exceptions\InternalException;

class SomeMembersHaveProgressActivity extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Некоторые пользователи уже проходили этот маршрут";
}

