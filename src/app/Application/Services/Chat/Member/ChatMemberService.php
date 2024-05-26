<?php

namespace App\Application\Services\Chat\Member;

use App\Application\Exceptions\Chat\ChatNotFound;
use Illuminate\Support\Collection;
use App\Application\DTO\Out\User\UserDto;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\Exceptions\Chat\Members\UserIsNotCreator;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\Contracts\Out\Managers\Notifier\INotifierManager;
use App\Application\Contracts\In\Services\Chat\Member\IChatMemberService;

class ChatMemberService implements IChatMemberService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly INotifierManager $notifier
    ) {
    }

    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws InvalidToken
     * @throws FailedToAddMembers
     * @throws UserIsNotCreator
     * @throws ChatNotFound
     */
    public function addMembers(AddMembersDto $addMembersDto): Collection
    {
        $chat = $this->chatRepository->findById($addMembersDto->chatId);

        $creator = $chat->members->first(fn ($value) => $value->id === $this->tokenManager->getAuthUser()->id);

        if (!$creator || $chat->creator->id !== $creator->id) {
            throw new UserIsNotCreator();
        }

        $members = $this->chatRepository->createMembers($addMembersDto);

        foreach ($this->chatRepository->findById($addMembersDto->chatId)->members as $member) {
            if ($member->id !== $this->tokenManager->getAuthUser()->id) {
                $this->notifier->sendNotification($member->id, $members);
            }
        }

        return $members;
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @return bool
     * @throws ChatNotFound
     * @throws FailedToDeleteMember
     * @throws InvalidToken
     * @throws UserIsNotCreator
     */
    public function deleteMember(int $chatId, int $memberId): bool
    {
        $chat = $this->chatRepository->findById($chatId);

        $creator = $chat->members->first(fn ($value) => $value->id === $this->tokenManager->getAuthUser()->id);

        if (!$creator || $chat->creator->id !== $creator->id) {
            throw new UserIsNotCreator();
        }

        $isDeleted = $this->chatRepository->deleteMember($chatId, $memberId);

        $members = $this->chatRepository->findById($chatId)->members;

        foreach ($members as $member) {
            if ($member->id !== $this->tokenManager->getAuthUser()->id) {
                $this->notifier->sendNotification($member->id, $members);
            }
        }

        return $isDeleted;
    }
}
