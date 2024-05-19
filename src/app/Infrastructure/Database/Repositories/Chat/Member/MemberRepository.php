<?php

namespace App\Infrastructure\Database\Repositories\Chat\Member;

use App\Application\Contracts\Out\Repositories\Chat\Member\IMemberRepository;
use App\Application\DTO\In\Chat\Member\AddMembersDto;
use App\Application\DTO\Out\User\UserDto;
use App\Application\Exceptions\Chat\Members\FailedToAddMembers;
use App\Application\Exceptions\Chat\Members\FailedToDeleteMember;
use App\Infrastructure\Database\Models\Chat;
use App\Infrastructure\Database\Models\ChatMember;
use App\Infrastructure\Database\Transaction\Interface\ITransactionManager;
use App\Utils\Mappers\Out\User\UserDtoMapper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

class MemberRepository implements IMemberRepository
{
    private readonly Model $model;

    public function __construct(
        private readonly ITransactionManager $transactionManager,
        ChatMember $member
    )
    {
        $this->model = $member;
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
            $this->transactionManager->beginTransaction();

            Chat::query()->where('id', $addMembersDto->chatId)
                ->where('creator_id', $userId)->firstOrFail();

            $members = new Collection();

            foreach ($addMembersDto->members as $member) {
                $members->add($this->model::query()->create([
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
            Chat::query()->where('id', $chatId)
                ->where('creator_id', $creatorId)->firstOrFail();

            return $this->model->query()->where('user_id', $memberId)
                ->where('chat_id', $chatId)->firstOrFail()->delete();
        } catch (Throwable) {
            throw new FailedToDeleteMember();
        }
    }
}
