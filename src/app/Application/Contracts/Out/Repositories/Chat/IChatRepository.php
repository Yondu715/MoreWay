<?php

namespace App\Application\Contracts\Out\Repositories\Chat;

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
use App\Application\Exceptions\Chat\ChatNotFound;
use App\Application\Exceptions\Chat\FailedToCreateChat;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Exceptions\Forbidden;
use Illuminate\Support\Collection;

interface IChatRepository
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
    public function create(CreateChatDto $createChatDto): ChatDto;

    /**
     * @param int $chatId
     * @param int $userId
     * @return ChatDto
     * @throws Forbidden
     */
    public function getChat(int $chatId, int $userId): ChatDto;


    /**
     * @param int $chatId
     * @return ChatDto
     * @throws ChatNotFound
     */
    public function findById(int $chatId): ChatDto;

    /**
     * @param AddMembersDto $addMembersDto
     * @param int $userId
     * @return Collection<int, UserDto>
     * @throws FailedToAddMembers
     */
    public function createMembers(AddMembersDto $addMembersDto): Collection;

    /**
     * @param int $chatId
     * @param int $memberId
     * @return bool
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId): bool;

    /**
     * @param int $chatId
     * @param int $userId
     * @return RouteDto
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId): RouteDto;

    /**
     * @param ChangeActivityDto $changeActivityDto
     * @return RouteDto
     * @throws FailedToChangeActivity
     */
    public function changeActivity(ChangeActivityDto $changeActivityDto): RouteDto;
}
