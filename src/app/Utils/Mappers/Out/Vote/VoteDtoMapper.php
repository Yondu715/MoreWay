<?php

namespace App\Utils\Mappers\Out\Vote;

use App\Application\DTO\Out\Vote\VoteDto;
use Illuminate\Support\Collection;

class VoteDtoMapper
{
    public static function fromAllAndAccepted(Collection $all, Collection $accepted): VoteDto
    {
        return new VoteDto(
            all: $all,
            accepted: $accepted,
        );
    }
}
