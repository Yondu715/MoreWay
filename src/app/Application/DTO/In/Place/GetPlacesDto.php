<?php

namespace App\Application\DTO\In\Place;

class GetPlacesDto
{
    public readonly float $lat;
    public readonly float $lon;
    public readonly ?string $cursor;
    public array $filter;
    public readonly int $limit;

    public function __construct(
        float $lat,
        float $lon,
        ?string $cursor,
        array $filter,
        int $limit
    ) {
        $this->lat = $lat;
        $this->lon = $lon;
        $this->cursor = $cursor;
        $this->filter = $filter;
        $this->limit = $limit;
    }

}
