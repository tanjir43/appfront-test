<?php

namespace App\Services;

use App\Traits\FileStorageTrait;
use Illuminate\Http\UploadedFile;
use App\Contracts\Services\FileStorageServiceInterface;

class FileStorageService implements FileStorageServiceInterface
{
    use FileStorageTrait;

    private const PRODUCTS_PATH = 'uploads/products';
    private const DISK = 'public';

    public function storeProductImage(UploadedFile $file): string
    {
        return $this->storeFile($file, self::PRODUCTS_PATH, null, self::DISK);
    }
}
