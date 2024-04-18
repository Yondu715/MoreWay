<?php

namespace App\Application\DTO\Collection;

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

}
