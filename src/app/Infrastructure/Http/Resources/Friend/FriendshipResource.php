<?php

namespace App\Infrastructure\Http\Resources\Friend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Infrastructure\Http\Resources\User\ShortUserResource;

/**
 * @mixin FriendshipDto
 */
class FriendshipResource extends JsonResource
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
