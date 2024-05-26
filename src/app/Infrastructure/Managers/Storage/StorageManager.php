<?php

namespace App\Infrastructure\Managers\Storage;

use App\Application\Contracts\Out\Managers\Storage\IStorageManager;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageManager implements IStorageManager
{
    /**
     * @param string $path
     * @param UploadedFile $uploadedFile
     * @return void
     */
    public function store(string $path, UploadedFile $uploadedFile): void
    {   
        $parts = explode('/', $path);
        $fileName = end($parts);
        $directory = implode('/', array_slice($parts, 0, -1));

        Storage::putFileAs($directory, $uploadedFile, $fileName);
    }
}
