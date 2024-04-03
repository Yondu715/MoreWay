<?php

namespace App\Exceptions\PlaceReview;

use App\Exceptions\BaseException;

class FailedToCreatePlaceReview extends BaseException
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось добавить отзыв";
}
