<?php

namespace App\Infrastructure\Http\Resources\Achievement;

use App\Application\DTO\Out\Achievement\UserAchievementDto;
use App\Infrastructure\Http\Resources\Achievement\Type\AchievementTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin UserAchievementDto
 */
class UserAchievementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->achievement->id,
            'name' => $this->achievement->name,
            'description' => $this->achievement->description,
            'target' => $this->achievement->target,
            'type' => AchievementTypeResource::make($this->achievement->type),
            'image' =>  url("/storage/{$this->achievement->image}"),
            'currentProgress' => $this->currentProgress
        ];
    }
}
