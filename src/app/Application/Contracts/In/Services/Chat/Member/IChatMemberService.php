<?php

namespace App\Application\Contracts\In\Services\Chat\Member;

use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Exceptions\InvalidToken;
use Illuminate\Support\Collection;

interface IChatMemberService
{
    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws InvalidToken
     * @throws FailedToAddMembers
     */
    public function addMembers(AddMembersDto $addMembersDto): Collection;

    /**
     * @param int $chatId
     * @param int $memberId
     * @return bool
     * @throws InvalidToken
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId): bool;
}
