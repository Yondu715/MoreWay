<?php

namespace App\Utils\Mappers\Collection;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Collection;

class CursorDtoMapper
{
    /**
     * @param CursorPaginator $paginator
     * @param callable $dtoMapper
     * @return CursorDto
     */
    public static function fromPaginatorAndMapper(CursorPaginator $paginator, callable $dtoMapper): CursorDto
    {
        return new CursorDto(
            data: collect($paginator->items())->map($dtoMapper),
            next_cursor: $paginator->nextCursor() ? $paginator->nextCursor()->encode() : null
        );
    }

    /**
     * @param Collection $places
     * @param string|null $nextCursor
     * @return CursorDto
     */
    public static function fromCollectionAndCursor(Collection $places, ?string $nextCursor): CursorDto
    {
        return new CursorDto(
            data: $places,
            next_cursor: $nextCursor
        );
    } 
}