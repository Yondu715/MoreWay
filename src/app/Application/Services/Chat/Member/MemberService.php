<?php

namespace App\Application\Services\Chat\Member;

use App\Application\Contracts\In\Services\Chat\Member\IMemberService;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\Member\IMemberRepository;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Infrastructure\Exceptions\InvalidToken;
use Illuminate\Support\Collection;

class MemberService implements IMemberService
{
    public function __construct(
        private readonly IMemberRepository $memberRepository,
        private readonly ITokenManager $tokenManager
    ) {}

    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws InvalidToken
     * @throws FailedToAddMembers
     */
    public function addMembers(AddMembersDto $addMembersDto): Collection
    {
        return $this->memberRepository->createMembers($addMembersDto, $this->tokenManager->getAuthUser()->id);
    }
}
