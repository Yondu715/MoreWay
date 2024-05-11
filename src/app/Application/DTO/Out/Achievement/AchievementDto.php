<?php

namespace App\Application\DTO\Out\Achievement;

use App\Infrastructure\Database\Models\AchievementType;

class AchievementDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $target;
    public readonly string $description;
    public readonly AchievementType $type;
    public readonly string $image;

    public function __construct(
        int $id,
        string $name,
        int $target,
        string $description,
        AchievementType $type,
        string $image,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->target = $target;
        $this->description = $description;
        $this->type = $type;
        $this->image = $image;
    }
}
