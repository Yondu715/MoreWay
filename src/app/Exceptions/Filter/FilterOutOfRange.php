<?php

namespace App\Exceptions\Filter;

use App\Exceptions\BaseException;

class FilterOutOfRange extends BaseException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Ошибка при создании фильтра";
}
