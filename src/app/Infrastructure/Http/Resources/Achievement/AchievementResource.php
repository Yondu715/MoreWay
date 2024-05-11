<?php

namespace App\Infrastructure\Http\Resources\Achievement;

use App\Application\DTO\Out\Achievement\AchievementDto;
use App\Infrastructure\Http\Resources\Achievement\Type\AchievementTypeResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AchievementDto
 */
class AchievementResource extends JsonResource
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
            'description' => $this->description,
            'target' => $this->target,
            'type' => AchievementTypeResource::make($this->type),
            'image' =>  url("/storage/{$this->image}")
        ];
    }
}
