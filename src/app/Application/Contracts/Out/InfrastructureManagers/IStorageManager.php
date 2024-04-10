<?php

namespace App\Application\Contracts\Out\InfrastructureManagers;

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
