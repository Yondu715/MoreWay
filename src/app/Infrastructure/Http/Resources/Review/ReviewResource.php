<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Review;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\DTO\Out\Review\ReviewDto;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ReviewDto
 */
class ReviewResource extends JsonResource
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
            'text' => $this->text,
            'rating' => $this->rating,
            'createdAt' => $this->created_at,
            'author' => UserResource::make($this->author),
        ];
    }
}
