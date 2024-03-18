<?php

namespace App\Exceptions\Review;

use App\Exceptions\BaseException;

class FailedToCreateReview extends BaseException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось добавить отзыв";
}
