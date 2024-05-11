<?php

namespace App\Application\DTO\Out\Achievement;

class UserAchievementDto
{
    public readonly AchievementDto $achievement;
    public readonly int $currentProgress;

    public function __construct(
        AchievementDto $achievement,
        int $currentProgress,
    ) {
        $this->achievement = $achievement;
        $this->currentProgress = $currentProgress;
    }
}
