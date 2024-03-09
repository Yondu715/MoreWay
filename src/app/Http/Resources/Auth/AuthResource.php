<?php

namespace App\Http\Resources\Auth;

use App\Services\Auth\DTO\OutAuthDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin OutAuthDto
 */
class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => UserResource::make($this->user),
            'accessToken' => $this->token
        ];
    }
}
