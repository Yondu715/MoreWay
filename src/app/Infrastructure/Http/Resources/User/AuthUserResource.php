<?php

namespace App\Infrastructure\Http\Resources\User;

use App\Application\Dto\Out\User\ExtendedUserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ExtendedUserDto
 */
class AuthUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->user),
            'score' => $this->score
        ];
    }
}
