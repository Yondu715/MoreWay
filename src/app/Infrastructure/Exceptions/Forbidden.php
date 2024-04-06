<?php

namespace App\Infrastructure\Exceptions;

class Forbidden extends ApiException
{
    /** @var int */
    protected $code = 403;

    /** @var string */
    protected $message = "Доступ к запрошенному ресурсу запрещен";
}
