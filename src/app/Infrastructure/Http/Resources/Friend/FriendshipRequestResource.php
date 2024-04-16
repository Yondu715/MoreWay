<?php

namespace App\Infrastructure\Http\Resources\Friend;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


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
            'user' => $this->user,
        ];
    }
}
