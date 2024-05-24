<?php

namespace App\Application\Services\Chat\Member;

use App\Application\Contracts\In\Services\Chat\Member\IChatMemberService;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;
use Illuminate\Support\Collection;

class ChatMemberService implements IChatMemberService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier
    ) {}

    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws InvalidToken
     * @throws FailedToAddMembers
     * @throws Forbidden
     */
    public function addMembers(AddMembersDto $addMembersDto): Collection
    {
        $members = $this->chatRepository->createMembers($addMembersDto, $this->tokenManager->getAuthUser()->id);

        foreach ($this->chatRepository->getChat($addMembersDto->chatId, $this->tokenManager->getAuthUser()->id)->members as $member) {
            if($member->id !== $this->tokenManager->getAuthUser()->id) {
                $this->notifier->sendNotification($member->id, $members);
            }
        }

        return $members;
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @return bool
     * @throws InvalidToken
     * @throws FailedToDeleteMember
     * @throws Forbidden
     */
    public function deleteMember(int $chatId, int $memberId): bool
    {
        $isDeleted = $this->chatRepository->deleteMember($chatId, $memberId, $this->tokenManager->getAuthUser()->id);

        $members = $this->chatRepository->getChat($chatId, $this->tokenManager->getAuthUser()->id)->members;

        foreach ($members as $member) {
            if ($member->id !== $this->tokenManager->getAuthUser()->id) {
                $this->notifier->sendNotification($member->id, $members);
            }
        }

        return $isDeleted;
    }
}
