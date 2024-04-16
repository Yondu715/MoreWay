<?php

namespace App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\Managers\Storage;

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Application\Contracts\Out\Managers\Storage\IStorageManager;
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
