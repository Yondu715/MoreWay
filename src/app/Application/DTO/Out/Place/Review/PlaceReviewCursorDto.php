<?php

namespace App\Application\DTO\Out\Place\Review;


use Illuminate\Contracts\Pagination\CursorPaginator;

class PlaceReviewCursorDto
{
    public readonly array $data;
    public readonly string $next_cursor;

    public function __construct(
        array $data,
        string $next_cursor,
    ) {
        $this->data = $data;
        $this->next_cursor = $next_cursor;
    }

    /**
     * @param CursorPaginator $paginator
     * @return array{data:array<PlaceReviewDto>, next_cursor:string}
     */
    public static function fromPaginator(CursorPaginator $paginator): array
    {
        return [
            'data' => collect($paginator->items())->map(function ($review) {
                return PlaceReviewDto::fromReviewModel($review);
            }),
            'next_cursor' => $paginator->nextCursor() ? $paginator->nextCursor()->encode() : null
        ];
    }
}
