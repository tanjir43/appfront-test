<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Contracts\Repositories\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Product
    {
        return $this->model->find($id);
    }

    public function create(array $data): Product
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->find($id);

        if (!$product) {
            throw new ModelNotFoundException("Product with ID {$id} not found");
        }

        $product->update($data);

        return $product;
    }

    public function delete(int $id): bool
    {
        $product = $this->find($id);

        if (!$product) {
            throw new ModelNotFoundException("Product with ID {$id} not found");
        }

        return $product->delete();
    }
}
