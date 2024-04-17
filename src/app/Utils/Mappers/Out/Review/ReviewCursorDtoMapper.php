<?php

namespace App\Utils\Mappers\Out\Review;

use App\Application\DTO\Collection\CursorDto;
use App\Utils\Mappers\Collection\CursorDtoMapper;
use App\Utils\Mappers\Out\Review\ReviewDtoMapper;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Database\Eloquent\Model;

class ReviewCursorDtoMapper
{
    /**
     * @param CursorPaginator $paginator
     * @return CursorDto
     */
    public static function fromPaginator(CursorPaginator $paginator): CursorDto
    {
        return CursorDtoMapper::fromPaginatorAndMapper($paginator, function (Model $review) {
            return ReviewDtoMapper::fromReviewModel($review);
        });
    }
}