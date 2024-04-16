<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Storage;

use Illuminate\Http\UploadedFile;

interface IStorageManager
{
    /**
     * @param string $path
     * @param UploadedFile $uploadedFile
     * @return void
     */
    public function store(string $path, UploadedFile $uploadedFile): void;
}
