<?php

namespace App\Application\DTO\Out\Place;

use Illuminate\Contracts\Pagination\CursorPaginator;

class PlaceCursorDto
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
     * @return array{data:array<PlaceDto>, next_cursor:string}
     */
    public static function fromPaginator(CursorPaginator $paginator): array
    {
        return [
            'data' => collect($paginator->items())->map(function ($place) {
                return PlaceDto::fromPlaceModel($place);
            }),
            'next_cursor' => $paginator->nextCursor() ? $paginator->nextCursor()->encode() : null
        ];
    }
}
