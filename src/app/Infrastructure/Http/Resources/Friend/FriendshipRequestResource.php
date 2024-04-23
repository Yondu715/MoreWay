<?php

namespace App\Infrastructure\Http\Resources\Friend;

use App\Application\DTO\Out\Friend\FriendshipRequestDto;
use App\Infrastructure\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'user' => UserResource::make($this->user),
        ];
    }
}
