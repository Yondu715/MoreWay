<?php

namespace App\Application\Exceptions\Filter;

use App\Application\Exceptions\InternalException;

class FilterOutOfRange extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Ошибка при создании фильтра";
}
