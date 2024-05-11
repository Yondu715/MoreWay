<?php

namespace App\Application\DTO\Out\Achievement\Type;

class AchievementTypeDto
{
    public readonly int $id;
    public readonly string $name;
    public readonly int $value;

    public function __construct(
        int $id,
        string $name,
        int $value,
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->value = $value;
    }
}
