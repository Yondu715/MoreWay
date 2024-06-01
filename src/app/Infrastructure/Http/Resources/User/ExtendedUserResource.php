<?php

namespace App\Infrastructure\Http\Resources\User;

use App\Application\Dto\Out\User\ExtendedUserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ExtendedUserDto
 */
class ExtendedUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => ShortUserResource::make($this->user),
            'relationship' => $this->relationship,
        ];
    }
}
