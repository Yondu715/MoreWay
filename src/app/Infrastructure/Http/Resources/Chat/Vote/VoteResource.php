<?php

namespace App\Infrastructure\Http\Resources\Chat\Vote;

use App\Application\DTO\Out\Vote\VoteDto;
use App\Infrastructure\Http\Resources\User\ShortUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin VoteDto
 */
class VoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'all' => ShortUserResource::collection($this->all),
            'accepted' => ShortUserResource::collection($this->accepted),
        ];
    }
}
