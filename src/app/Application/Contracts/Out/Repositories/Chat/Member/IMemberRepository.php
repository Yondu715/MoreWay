<?php

namespace App\Application\Contracts\Out\Repositories\Chat\Member;

use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use Illuminate\Support\Collection;

interface IMemberRepository
{
    /**
     * @param AddMembersDto $addMembersDto
     * @param int $userId
     * @return Collection<int, UserDto>
     * @throws FailedToAddMembers
     */
    public function createMembers(AddMembersDto $addMembersDto, int $userId): Collection;

    /**
     * @param int $chatId
     * @param int $memberId
     * @param int $creatorId
     * @return bool
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId, int $creatorId): bool;
}
