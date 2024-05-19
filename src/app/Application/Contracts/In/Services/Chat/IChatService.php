<?php

namespace App\Application\Contracts\In\Services\Chat;

use App\Application\DTO\Collection\CursorDto;
use App\Application\DTO\In\Chat\CreateChatDto;
use App\Application\DTO\In\Chat\GetUserChatsDto;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\Chat\ChatDto;
use App\Application\DTO\Out\Route\RouteDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Activity\FailedToGetActivity;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Exceptions\Forbidden;
use App\Infrastructure\Exceptions\InvalidToken;
use Illuminate\Support\Collection;

interface IChatService
{
    /**
     * @param GetUserChatsDto $getUserChatsDto
     * @return CursorDto
     */
    public function getUserChats(GetUserChatsDto $getUserChatsDto): CursorDto;

    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function createChat(CreateChatDto $createChatDto): ChatDto;

    /**
     * @param int $chatId
     * @return ChatDto
     * @throws Forbidden
     * @throws InvalidToken
     */
    public function getChat(int $chatId): ChatDto;

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

    /**
     * @param int $chatId
     * @return RouteDto
     * @throws InvalidToken
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto;
}
