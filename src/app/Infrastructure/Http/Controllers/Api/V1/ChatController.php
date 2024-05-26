<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Utils\Mappers\In\Chat\CreateChatDtoMapper;
use App\Utils\Mappers\In\Chat\GetUserChatsDtoMapper;
use App\Infrastructure\Http\Resources\Chat\ChatResource;
use App\Utils\Mappers\In\Chat\Member\AddMembersDtoMapper;
use App\Infrastructure\Http\Resources\Route\RouteResource;
use App\Utils\Mappers\In\Chat\Message\AddMessageDtoMapper;
use App\Utils\Mappers\In\Chat\Message\GetMessagesDtoMapper;
use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Infrastructure\Http\Requests\Chat\CreateChatRequest;
use App\Infrastructure\Http\Requests\Chat\GetUserChatsRequest;
use App\Utils\Mappers\In\Chat\Activity\ChangeActivityDtoMapper;
use App\Infrastructure\Http\Resources\User\UserCollectionResource;
use App\Infrastructure\Http\Requests\Chat\Member\AddMembersRequest;
use App\Infrastructure\Http\Resources\Chat\Message\MessageResource;
use App\Infrastructure\Http\Resources\Chat\ShortChatCursorResource;
use App\Infrastructure\Http\Requests\Chat\Message\AddMessageRequest;
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
        private readonly IChatMemberService $memberService
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
     */
    public function getChat(int $chatId): ChatResource
    {
        return ChatResource::make(
            $this->chatService->getChat($chatId)
        );
    }

    /**
     * @param AddMembersRequest $addMemberRequest
     * @return UserCollectionResource
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
     */
    public function deleteMember(int $chatId, int $memberId): Response
    {
        $this->memberService->deleteMember($chatId, $memberId);
        return response()->noContent();
    }

    /**
     * @param GetMessagesRequest $getMessagesRequest
     * @return MessageCursorResource
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
     */
    public function changeActivity(ChangeActivityRequest $changeActivityRequest): RouteResource
    {
        $changeActivityDto = ChangeActivityDtoMapper::fromRequest($changeActivityRequest);
        return RouteResource::make(
            $this->activityService->changeActivity($changeActivityDto)
        );
    }
}
