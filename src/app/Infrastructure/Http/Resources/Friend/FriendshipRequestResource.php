<?php

namespace App\Infrastructure\Http\Resources\Friend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use App\Infrastructure\Http\Resources\User\ShortUserResource;

/**
 * @mixin FriendshipRequestDto
 */
class FriendshipRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => ShortUserResource::make($this->user),
            'friend' => ShortUserResource::make($this->friend)
        ];
    }
}
