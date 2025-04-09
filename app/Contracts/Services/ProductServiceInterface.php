<?php

namespace App\Contracts\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Collection;

interface ProductServiceInterface
{
    public function getAllProducts(): Collection;

    public function getProductById(int $id): ?Product;

    public function createProduct(array $data, ?UploadedFile $image = null): Product;

    public function updateProduct(int $id, array $data, ?UploadedFile $image = null): Product;

    public function updateProductFromCommand(int $id, array $data): Product;

    public function deleteProduct(int $id): bool;
}
