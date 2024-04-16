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
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        Storage::put($path, $uploadedFile);
    }
}
