<?php

namespace App\Application\DTO\Out\Place;

use App\Application\DTO\Collection\CursorDto;
use Illuminate\Support\Collection;

class PlaceCursorDto extends CursorDto
{
    /**
     * @param Collection $places
     * @param string|null $nextCursor
     * @return CursorDto
     */
    public static function fromPaginator(Collection $places, ?string $nextCursor): CursorDto
    {
        return CursorDto::fromCollectionAndCursor($places, $nextCursor);
    }
}
