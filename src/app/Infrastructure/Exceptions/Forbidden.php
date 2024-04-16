<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Exceptions;

class Forbidden extends ApiException
{
    /** @var int */
    protected $code = 403;

    /** @var string */
    protected $message = "Доступ к запрошенному ресурсу запрещен";
}
