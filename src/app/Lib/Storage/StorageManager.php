<?php

namespace App\Lib\Storage;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageManager
{
    public function store(string $path, UploadedFile $uploadedFile): void
    {
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
        Storage::put($path, $uploadedFile);
    }
}
