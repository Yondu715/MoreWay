<?php

namespace App\Application\DTO\Collection;

use Illuminate\Support\Collection;

class CursorDto
{
    public readonly Collection $data;
    public readonly ?string $cursor;

    public function __construct(
        Collection $data,
        ?string $cursor,
    ) {
        $this->data = $data;
        $this->cursor = $cursor;
    }

}
