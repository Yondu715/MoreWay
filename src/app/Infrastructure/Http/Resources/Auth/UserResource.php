<?php

namespace App\Infrastructure\Http\Resources\Auth;

use App\Application\DTO\Out\Auth\UserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserDto
 */
class UserResource extends JsonResource
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
            'name' => $this->name,
            'avatar' => url("/storage/{$this->avatar}"),
            'email' => $this->email,
        ];
    }
}
