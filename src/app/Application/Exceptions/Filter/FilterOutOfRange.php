<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Filter;

use Exception;

class FilterOutOfRange extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Ошибка при создании фильтра";
}
