<?php

namespace App\Application\DTO\Collection;


use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Support\Collection;

class CursorDto
{
    public readonly Collection $data;
    public readonly ?string $next_cursor;

    public function __construct(
        Collection $data,
        ?string $next_cursor,
    ) {
        $this->data = $data;
        $this->next_cursor = $next_cursor;
    }

    /**
     * @param CursorPaginator $paginator
     * @param callable $dtoMapper
     * @return self
     */
    public static function fromPaginatorAndMapper(CursorPaginator $paginator, callable $dtoMapper): self
    {
        return new self(
            data: collect($paginator->items())->map($dtoMapper),
            next_cursor: $paginator->nextCursor() ? $paginator->nextCursor()->encode() : null
        );
    }

    public static function fromCollectionAndCursor(Collection $places, ?string $nextCursor):self
    {
        return new self(
            data: $places,
            next_cursor: $nextCursor
        );
    }
}
