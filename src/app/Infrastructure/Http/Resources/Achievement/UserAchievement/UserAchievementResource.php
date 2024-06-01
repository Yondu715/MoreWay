<?php

namespace App\Infrastructure\Http\Resources\Achievement\UserAchievement;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Application\DTO\Out\Achievement\UserAchievementDto;
use App\Infrastructure\Http\Resources\Achievement\AchievementResource;

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
            'achievement' => AchievementResource::make($this->achievement),
            'currentProgress' => $this->currentProgress
        ];
    }
}
