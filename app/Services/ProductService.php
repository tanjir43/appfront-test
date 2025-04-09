<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use App\Events\ProductPriceChanged;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Services\ProductServiceInterface;
use App\Contracts\Services\FileStorageServiceInterface;
use App\Contracts\Repositories\ProductRepositoryInterface;

class ProductService implements ProductServiceInterface
{
    protected ProductRepositoryInterface $productRepository;
    protected FileStorageServiceInterface $fileStorageService;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        FileStorageServiceInterface $fileStorageService
    ) {
        $this->productRepository = $productRepository;
        $this->fileStorageService = $fileStorageService;
    }

    public function getAllProducts(): Collection
    {
        return $this->productRepository->all();
    }

    public function getProductById(int $id): ?Product
    {
        return $this->productRepository->find($id);
    }

    public function createProduct(array $data, ?UploadedFile $image = null): Product
    {
        $productData = $data;

        if ($image) {
            $imagePath = $this->fileStorageService->storeProductImage($image);
            $productData['image'] = $imagePath;
        } else {
            $productData['image'] = 'product-placeholder.jpg';
        }

        return $this->productRepository->create($productData);
    }

    public function updateProduct(int $id, array $data, ?UploadedFile $image = null): Product
    {
        $product = $this->getProductById($id);
        $oldPrice = $product->price;
        $productData = $data;

        if ($image) {
            $imagePath = $this->fileStorageService->storeProductImage($image);
            $productData['image'] = $imagePath;
        }

        $product = $this->productRepository->update($id, $productData);

        if (isset($data['price']) && $oldPrice != $product->price) {
            $this->triggerPriceChangeEvent($product, $oldPrice, $product->price);
        }

        return $product;
    }

    public function updateProductFromCommand(int $id, array $data): Product
    {
        $product = $this->getProductById($id);
        $oldPrice = $product->price;

        $product = $this->productRepository->update($id, $data);

        if (isset($data['price']) && $oldPrice != $product->price) {
            $this->triggerPriceChangeEvent($product, $oldPrice, $product->price);
        }

        return $product;
    }

    public function deleteProduct(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    protected function triggerPriceChangeEvent(Product $product, float|string $oldPrice, float|string $newPrice): void
    {
        try {
            event(new ProductPriceChanged($product, $oldPrice, $newPrice));

            Log::info("Price change event triggered for product ID: {$product->id}");
        } catch (\Exception $e) {
            Log::error("Failed to trigger price change event: " . $e->getMessage());
        }
    }
}
