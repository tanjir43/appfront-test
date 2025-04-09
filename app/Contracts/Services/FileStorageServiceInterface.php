<?php

namespace App\Contracts\Services;

use Illuminate\Http\UploadedFile;

interface FileStorageServiceInterface
{
    public function storeProductImage(UploadedFile $file): string;
}
