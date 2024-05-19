<?php

namespace App\Infrastructure\Http\Controllers\Api\V1;

use App\Application\Contracts\In\Services\Chat\IChatService;
use App\Application\Contracts\In\Services\Chat\Member\IMemberService;
use App\Application\Contracts\In\Services\Chat\Message\IMessageService;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Application\Exceptions\Chat\Message\FailedToGetMessages;
use App\Infrastructure\Exceptions\ApiException;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;
use App\Infrastructure\Http\Requests\Chat\CreateChatRequest;
use App\Infrastructure\Http\Requests\Chat\GetUserChatsRequest;
use App\Infrastructure\Http\Requests\Chat\Member\AddMembersRequest;
use App\Infrastructure\Http\Requests\Chat\Message\AddMessageRequest;
use App\Infrastructure\Http\Requests\Chat\Message\GetMessagesRequest;
use App\Infrastructure\Http\Resources\Chat\ChatResource;
use App\Infrastructure\Http\Resources\Chat\Message\MessageCursorResource;
use App\Infrastructure\Http\Resources\Chat\ShortChatCursorResource;
use App\Infrastructure\Http\Resources\Chat\Message\MessageResource;
use App\Infrastructure\Http\Resources\User\UserCollectionResource;
use App\Utils\Mappers\In\Chat\CreateChatDtoMapper;
use App\Utils\Mappers\In\Chat\GetUserChatsDtoMapper;
use App\Utils\Mappers\In\Chat\Member\AddMembersDtoMapper;
use App\Utils\Mappers\In\Chat\Message\AddMessageDtoMapper;
use App\Utils\Mappers\In\Chat\Message\GetMessagesDtoMapper;
use Illuminate\Http\Response;

class ChatController
{
    public function __construct(
        private readonly IChatService $chatService,
        private readonly IMessageService $messageService,
        private readonly IMemberService  $memberService,
    ) {}

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
     * @throws ApiException
     */
    public function createChat(CreateChatRequest $createChatRequest): ChatResource
    {
        try {
            $createChatDto = CreateChatDtoMapper::fromRequest($createChatRequest);
            return ChatResource::make(
                $this->chatService->createChat($createChatDto)
            );
        } catch (FailedToCreateChat $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $chatId
     * @return ChatResource
     * @throws ApiException
     */
    public function getChat(int $chatId): ChatResource
    {
        try {
            return ChatResource::make(
                $this->chatService->getChat($chatId)
            );
        } catch (Forbidden|InvalidToken $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param AddMembersRequest $addMemberRequest
     * @return UserCollectionResource
     * @throws ApiException
     */
    public function addMembers(AddMembersRequest $addMemberRequest): UserCollectionResource
    {
        $addMembersDto = AddMembersDtoMapper::fromRequest($addMemberRequest);
        try {
            return UserCollectionResource::make(
                $this->memberService->addMembers($addMembersDto)
            );
        } catch (FailedToAddMembers|InvalidToken $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @return Response
     * @throws ApiException
     */
    public function deleteMember(int $chatId, int $memberId): Response
    {
        try {
            $this->memberService->deleteMember($chatId, $memberId);
            return response()->noContent();
        } catch (FailedToDeleteMember|InvalidToken $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param GetMessagesRequest $getMessagesRequest
     * @return MessageCursorResource
     * @throws ApiException
     */
    public function getMessages(GetMessagesRequest $getMessagesRequest): MessageCursorResource
    {
        try {
            $getMessagesDto = GetMessagesDtoMapper::fromRequest($getMessagesRequest);
            return MessageCursorResource::make(
                $this->messageService->getMessages($getMessagesDto)
            );
        } catch (FailedToGetMessages|InvalidToken $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param AddMessageRequest $addMessageRequest
     * @return MessageResource
     * @throws ApiException
     */
    public function addMessage(AddMessageRequest $addMessageRequest): MessageResource
    {
        try {
            $addMessageDto = AddMessageDtoMapper::fromRequest($addMessageRequest);
            return MessageResource::make(
                $this->messageService->createMessage($addMessageDto)
            );
        } catch (FailedToGetMessages $e) {
            throw new ApiException($e->getMessage(), $e->getCode());
        }
    }
}
