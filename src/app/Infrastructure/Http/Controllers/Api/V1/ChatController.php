<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Application\Exceptions\Chat\ChatNotFound;
use App\Utils\Mappers\In\Chat\CreateChatDtoMapper;
use App\Utils\Mappers\In\Chat\GetUserChatsDtoMapper;
use App\Application\Exceptions\Route\RouteIsCompleted;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Infrastructure\Http\Resources\Chat\ChatResource;
use App\Utils\Mappers\In\Chat\Member\AddMembersDtoMapper;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use App\Utils\Mappers\In\Chat\Message\AddMessageDtoMapper;
use App\Utils\Mappers\In\Chat\Message\GetMessagesDtoMapper;
use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Infrastructure\Http\Requests\Chat\CreateChatRequest;
use App\Application\Exceptions\Chat\SomeMembersHaveActiveChat;
use App\Infrastructure\Http\Requests\Chat\GetUserChatsRequest;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Utils\Mappers\In\Chat\Activity\ChangeActivityDtoMapper;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Http\Resources\User\UserCollectionResource;
use App\Infrastructure\Http\Requests\Chat\Member\AddMembersRequest;
use App\Infrastructure\Http\Resources\Chat\Message\MessageResource;
use App\Infrastructure\Http\Resources\Chat\ShortChatCursorResource;
use App\Application\Exceptions\Chat\Activity\FailedToChangeActivity;
use App\Application\Exceptions\Chat\SomeMembersHaveProgressActivity;
use App\Infrastructure\Http\Requests\Chat\Message\AddMessageRequest;
use App\Application\Contracts\In\Services\Chat\Vote\IChatVoteService;
use App\Infrastructure\Http\Requests\Chat\Message\GetMessagesRequest;
use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Contracts\In\Services\Chat\Member\IChatMemberService;
use App\Infrastructure\Http\Requests\Chat\Activity\ChangeActivityRequest;
use App\Infrastructure\Http\Resources\Chat\Message\MessageCursorResource;
use App\Application\Contracts\In\Services\Chat\Activity\IChatActivityService;

class ChatController
{
    public function __construct(
        private readonly IChatService $chatService,
        private readonly IMessageService $messageService,
        private readonly IChatActivityService $activityService,
        private readonly IChatMemberService $memberService,
        private readonly IChatVoteService $voteService,
    ) {
    }

    /**
     * @param GetUserChatsRequest $getUserChatsRequest
     * @return ShortChatCursorResource
     */
    public function getUserChats(GetUserChatsRequest $getUserChatsRequest): ShortChatCursorResource
    {
        $getUserChatsDto = GetUserChatsDtoMapper::fromRequest($getUserChatsRequest);
        return ShortChatCursorResource::make(
            $this->chatService->getUserChats($getUserChatsDto)
        );
    }

    /**
     * @param CreateChatRequest $createChatRequest
     * @return ChatResource
     * @throws FailedToCreateChat
     */
    public function createChat(CreateChatRequest $createChatRequest): ChatResource
    {
        $createChatDto = CreateChatDtoMapper::fromRequest($createChatRequest);
        return ChatResource::make(
            $this->chatService->createChat($createChatDto)
        );
    }

    /**
     * @param int $chatId
     * @return ChatResource
     * @throws Forbidden
     * @throws InvalidToken
     */
    public function getChat(int $chatId): ChatResource
    {
        return ChatResource::make(
            $this->chatService->getChat($chatId)
        );
    }

    /**
     * @param int $chatId
     * @return void
     * @throws InvalidToken
     * @throws ChatNotFound
     * @throws SomeMembersHaveActiveChat
     * @throws SomeMembersHaveProgressActivity
     * @throws RouteIsCompleted
     */
    public function changeVoteActivity(int $chatId): void
    {
        $this->voteService->changeVoteActivity($chatId);
    }

    /**
     * @param AddMembersRequest $addMemberRequest
     * @return UserCollectionResource
     * @throws InvalidToken
     * @throws FailedToAddMembers
     */
    public function addMembers(AddMembersRequest $addMemberRequest): UserCollectionResource
    {
        $addMembersDto = AddMembersDtoMapper::fromRequest($addMemberRequest);
        return UserCollectionResource::make(
            $this->memberService->addMembers($addMembersDto)
        );
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @return Response
     * @throws InvalidToken
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId): Response
    {
        $this->memberService->deleteMember($chatId, $memberId);
        return response()->noContent();
    }

    /**
     * @param GetMessagesRequest $getMessagesRequest
     * @return MessageCursorResource
     * @throws InvalidToken
     */
    public function getMessages(GetMessagesRequest $getMessagesRequest): MessageCursorResource
    {
        $getMessagesDto = GetMessagesDtoMapper::fromRequest($getMessagesRequest);
        return MessageCursorResource::make(
            $this->messageService->getMessages($getMessagesDto)
        );
    }

    /**
     * @param AddMessageRequest $addMessageRequest
     * @return MessageResource
     */
    public function addMessage(AddMessageRequest $addMessageRequest): MessageResource
    {
        $addMessageDto = AddMessageDtoMapper::fromRequest($addMessageRequest);
        return MessageResource::make(
            $this->messageService->createMessage($addMessageDto)
        );
    }

    /**
     * @param int $chatId
     * @return RouteResource
     * @throws InvalidToken
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteResource
    {
        return RouteResource::make(
            $this->activityService->getActivity($chatId)
        );
    }

    /**
     * @param ChangeActivityRequest $changeActivityRequest
     * @return RouteResource
     * @throws InvalidToken
     * @throws FailedToChangeActivity
     */
    public function changeActivity(ChangeActivityRequest $changeActivityRequest): RouteResource
    {
        $changeActivityDto = ChangeActivityDtoMapper::fromRequest($changeActivityRequest);
        return RouteResource::make(
            $this->activityService->changeActivity($changeActivityDto)
        );
    }
}
