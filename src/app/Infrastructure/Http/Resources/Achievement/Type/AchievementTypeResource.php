<?php

namespace App\Infrastructure\Http\Resources\Achievement\Type;

use App\Application\DTO\Out\Achievement\Type\AchievementTypeDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AchievementTypeDto
 */
class AchievementTypeResource extends JsonResource
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
        ];
    }
}
