<?php

namespace App\Application\Contracts\Out\Managers;

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
