<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait FileStorageTrait
{
    public function storeFile(
        UploadedFile $file,
        string $directory = 'uploads',
        ?string $filename = null,
        string $disk = 'public'
    ): string {
        $filename = $filename ?? $this->generateUniqueFilename($file);

        $path = $file->storeAs($directory, $filename, $disk);

        return Storage::disk($disk)->url($path);
    }

    protected function generateUniqueFilename(UploadedFile $file): string
    {
        return Str::uuid() . '.' . $file->getClientOriginalExtension();
    }

    public function deleteFile(string $path, string $disk = 'public'): bool
    {
        $path = $this->normalizeFilePath($path);

        if (Storage::disk($disk)->exists($path)) {
            return Storage::disk($disk)->delete($path);
        }

        return false;
    }

    protected function normalizeFilePath(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            $basePath = config('app.url') . '/storage/';
            return Str::after($path, $basePath);
        }

        if (Str::startsWith($path, '/storage/')) {
            return Str::after($path, '/storage/');
        }

        return $path;
    }
}
