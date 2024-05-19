<?php

namespace App\Infrastructure\Http\Resources\Rating;

use App\Application\DTO\Out\Rating\RatingDto;
use App\Infrastructure\Http\Resources\User\ShortUserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin RatingDto
 */
class RatingResource extends JsonResource
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
            'score' => $this->score
        ];
    }
}
