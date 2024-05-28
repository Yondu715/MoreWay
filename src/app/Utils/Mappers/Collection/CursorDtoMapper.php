<?php

namespace App\Utils\Mappers\Collection;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Contracts\Pagination\CursorPaginator;

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
            cursor: $paginator->nextCursor() ? $paginator->nextCursor()->encode() : null
        );
    }

}