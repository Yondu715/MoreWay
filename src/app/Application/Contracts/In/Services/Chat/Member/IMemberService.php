<?php

namespace App\Application\Contracts\In\Services\Chat\Member;

use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Infrastructure\Exceptions\InvalidToken;
use Illuminate\Support\Collection;

interface IMemberService
{
    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws InvalidToken
     * @throws FailedToAddMembers
     */
    public function addMembers(AddMembersDto $addMembersDto): Collection;
}
