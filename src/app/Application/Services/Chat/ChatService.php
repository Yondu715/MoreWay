<?php

namespace App\Application\Services\Chat;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\Out\Managers\Notifier\Chat\IChatNotifierManager;
use App\Application\Contracts\Out\Managers\Token\ITokenManager;
use App\Application\Contracts\Out\Repositories\Chat\IChatRepository;
use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\Activity\ChangeActivityDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Activity\FailedToChangeActivity;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Database\Models\Route;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;
use Illuminate\Support\Collection;

class ChatService implements IChatService
{
    public function __construct(
        private readonly IChatRepository $chatRepository,
        private readonly ITokenManager $tokenManager,
        private readonly IChatNotifierManager $notifierManager
    ) {}

    /**
     * @param GetUserChatsDto $getUserChatsDto
     * @return CursorDto
     */
    public function getUserChats(GetUserChatsDto $getUserChatsDto): CursorDto
    {
        return $this->chatRepository->getUserChats($getUserChatsDto);
    }

    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function createChat(CreateChatDto $createChatDto): ChatDto
    {
        $chat = $this->chatRepository->create($createChatDto);

        foreach ($chat->members as $member) {
            $this->notifierManager->sendNotification($member->id, $chat);
        }

        return $chat;
    }

    /**
     * @param int $chatId
     * @return ChatDto
     * @throws Forbidden
     * @throws InvalidToken
     */
    public function getChat(int $chatId): ChatDto
    {
        return $this->chatRepository->getChat($chatId, $this->tokenManager->getAuthUser()->id);
    }

    /**
     * @param AddMembersDto $addMembersDto
     * @return Collection<int, UserDto>
     * @throws InvalidToken
     * @throws FailedToAddMembers
     */
    public function addMembers(AddMembersDto $addMembersDto): Collection
    {
        return $this->chatRepository->createMembers($addMembersDto, $this->tokenManager->getAuthUser()->id);
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @return bool
     * @throws InvalidToken
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId): bool
    {
        return $this->chatRepository->deleteMember($chatId, $memberId, $this->tokenManager->getAuthUser()->id);
    }

    /**
     * @param int $chatId
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto
    {
        return $this->chatRepository->getActivity($chatId, $this->tokenManager->getAuthUser()->id);
    }

    /**
     * @param ChangeActivityDto $changeActivityDto
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToChangeActivity
     */
    public function changeActivity(changeActivityDto $changeActivityDto): RouteDto
    {
        return $this->chatRepository->changeActivity($changeActivityDto, $this->tokenManager->getAuthUser()->id);
    }
}
