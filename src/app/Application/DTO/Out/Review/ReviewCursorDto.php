<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review;


use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Collection\CursorDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

class ReviewCursorDto extends CursorDto
{
    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDto::fromPaginatorAndMapper($paginator, function ($review){
            return ReviewDto::fromReviewModel($review);
        });
    }
}
