<?php

namespace App\Application\Exceptions\Place\Review;

use Exception;

class FailedToCreatePlaceReview extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось добавить отзыв";
}
