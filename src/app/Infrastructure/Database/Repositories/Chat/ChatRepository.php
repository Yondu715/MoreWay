<?php

namespace App\Infrastructure\Database\Repositories\Chat;

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
use App\Infrastructure\Database\Models\Chat;
use App\Infrastructure\Database\Models\ChatActiveRoute;
use App\Infrastructure\Database\Models\ChatMember;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Infrastructure\Exceptions\Forbidden;
use App\Utils\Mappers\Out\Chat\ChatDtoMapper;
use App\Utils\Mappers\Out\Route\RouteDtoMapper;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

class ChatRepository implements IChatRepository
{
    private readonly Model $model;

    public function __construct(
        private readonly ITransactionManager $transactionManager,
        Chat $chat
    )
    {
        $this->model = $chat;
    }

    /**
     * @param GetUserChatsDto $getUserChatsDto
     * @return CursorDto
     */
    public function getUserChats(GetUserChatsDto $getUserChatsDto): CursorDto
    {
        $paginator = $this->model::query()
            ->whereHas('members', function ($query) use ($getUserChatsDto) {
                $query->where('user_id', $getUserChatsDto->userId);
            })->cursorPaginate(perPage: $getUserChatsDto->limit , cursor: $getUserChatsDto->cursor);
        return ChatDtoMapper::fromPaginator($paginator);
    }

    /**
     * @param CreateChatDto $createChatDto
     * @return ChatDto
     * @throws FailedToCreateChat
     */
    public function create(CreateChatDto $createChatDto): ChatDto
    {
        try {
            $this->transactionManager->beginTransaction();

            /** @var Chat $chat */
            $chat = $this->model->query()->create([
                'name' => $createChatDto->name,
                'creator_id' => $createChatDto->creatorId,
            ]);

            ChatActiveRoute::query()->create([
                'chat_id' => $chat->id,
                'route_id' => $createChatDto->routeId,
            ]);

            // $chat->users()->attach([...$createChatDto->members, $createChatDto->creatorId]);

            foreach ($createChatDto->members as $member) {
                ChatMember::query()->create([
                    'chat_id' => $chat->id,
                    'user_id' => $member,
                ]);
            }

            ChatMember::query()->create([
                'chat_id' => $chat->id,
                'user_id' => $createChatDto->creatorId,
            ]);

            $chatDto = ChatDtoMapper::fromChatModel($chat);

            $this->transactionManager->commit();

            return $chatDto;
        } catch (Throwable) {
            $this->transactionManager->rollback();
            throw new FailedToCreateChat();
        }
    }

    /**
     * @param int $chatId
     * @param int $userId
     * @return ChatDto
     * @throws Forbidden
     */
    public function getChat(int $chatId, int $userId): ChatDto
    {
        try{
            /** @var Chat $chat */
            $chat = $this->model::query()->where('id', $chatId)
                ->whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->firstOrFail();

            return ChatDtoMapper::fromChatModel($chat);
        } catch (Throwable) {
            throw new Forbidden();
        }
    }

    /**
     * @param AddMembersDto $addMembersDto
     * @param int $userId
     * @return Collection<int, UserDto>
     * @throws FailedToAddMembers
     */
    public function createMembers(AddMembersDto $addMembersDto, int $userId): Collection
    {
        try {

            $this->model->query()->where('id', $addMembersDto->chatId)
                ->where('creator_id', $userId)->firstOrFail();

            // $this->model->query()->where([
            //     'id' => $addMembersDto->chatId,
            //     'creator_id' => $userId
            // ])->firstOrFail();

            $members = new Collection();

            $this->transactionManager->beginTransaction();

            foreach ($addMembersDto->members as $member) {
                $members->add(ChatMember::query()->create([
                    'chat_id' => $addMembersDto->chatId,
                    'user_id' => $member,
                ]));
            }

            $this->transactionManager->commit();

            return UserDtoMapper::fromChatMemberCollection($members);
        } catch (Throwable) {
            $this->transactionManager->rollBack();
            throw new FailedToAddMembers();
        }
    }

    /**
     * @param int $chatId
     * @param int $memberId
     * @param int $creatorId
     * @return bool
     * @throws FailedToDeleteMember
     */
    public function deleteMember(int $chatId, int $memberId, int $creatorId): bool
    {
        try {
             $chat = $this->model->query()->where('id', $chatId)
                ->where('creator_id', $creatorId)->firstOrFail();

            return $chat->where('user_id', $memberId)->firstOrFail()->delete();
        } catch (Throwable) {
            throw new FailedToDeleteMember();
        }
    }

    /**
     * @param int $chatId
     * @param int $userId
     * @return RouteDto
     * @throws FailedToGetActivity
     */
    public function getActivity(int $chatId, int $userId): RouteDto
    {
        try{
            /** @var Chat $chat */
            $chat = $this->model->query()->whereHas('members', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('id', $chatId)->firstOrFail();

            return RouteDtoMapper::fromRouteModel($chat->activeRoute->route);
        } catch (Throwable) {
            throw new FailedToGetActivity();
        }
    }

    /**
     * @param ChangeActivityDto $changeActivityDto
     * @param int $creatorId
     * @return RouteDto
     * @throws FailedToChangeActivity
     */
    public function changeActivity(ChangeActivityDto $changeActivityDto, int $creatorId): RouteDto
    {
        try {
            $this->model->query()->where('id', $changeActivityDto->chatId)
                ->where('creator_id', $creatorId)->firstOrFail();

            /** @var ChatActiveRoute $activity */
            $activity = ChatActiveRoute::query()->where('chat_id', $changeActivityDto->chatId)->first();

            $activity->update([
                'route_id' => $changeActivityDto->routeId,
            ]);

            return RouteDtoMapper::fromRouteModel($activity->route);
        } catch (Throwable) {
            throw new FailedToChangeActivity();
        }
    }
}
