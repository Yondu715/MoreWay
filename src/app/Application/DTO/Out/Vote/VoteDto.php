<?php

namespace App\Application\DTO\Out\Vote;

use Illuminate\Support\Collection;

class VoteDto
{
    public readonly Collection $all;
    public readonly Collection $accepted;

    public function __construct(
        Collection $all,
        Collection $accepted,
    ) {
        $this->all = $all;
        $this->accepted = $accepted;
    }
}
