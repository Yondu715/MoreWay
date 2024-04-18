<?php

namespace App\Application\DTO\Out\Place\Image;

class ImageDto
{
    public readonly int $id;
    public readonly string $path;

    public function __construct(
        int $id,
        string $path,
    ) {
        $this->id = $id;
        $this->path = $path;
    }
}
