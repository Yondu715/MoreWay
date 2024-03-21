<?php

namespace App\Exceptions\Auth;

use App\Exceptions\BaseException;

class Forbidden extends BaseException
{
    /** @var int */
    protected $code = 403;

    /** @var string */
    protected $message = "Доступ к запрошенному ресурсу запрещен";
}
