<?php

namespace App\Application\DTO\In\User;

class GetUsersDto
{

    public readonly ?string $cursor;
    public array $filter;
    public readonly ?int $limit;

    public function __construct(
        ?string $cursor,
        array $filter,
        ?int $limit
    ) {
        $this->cursor = $cursor;
        $this->filter = $filter;
        $this->limit = $limit;
    }

}
