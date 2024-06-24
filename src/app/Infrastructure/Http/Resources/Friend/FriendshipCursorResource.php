<?php

namespace App\Infrastructure\Http\Resources\Friend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTO\Out\Friend\FriendshipDto;
use App\Infrastructure\Http\Resources\User\ShortUserResource;

/**
 * @mixin CursorDto
 */
class FriendshipCursorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => FriendshipResource::collection($this->data),
            'meta' => [
                'cursor' => $this->cursor
            ]
        ];
    }
}
