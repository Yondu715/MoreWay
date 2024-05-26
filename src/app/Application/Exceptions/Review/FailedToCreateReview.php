<?php

namespace App\Application\Exceptions\Review;

use App\Application\Exceptions\InternalException;

class FailedToCreateReview extends InternalException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось добавить отзыв";
}
