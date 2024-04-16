<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Exceptions\Review;

use Exception;

class FailedToCreateReview extends Exception
{
    /** @var int */
    protected $code = 400;

    /** @var string */
    protected $message = "Не удалось добавить отзыв";
}
