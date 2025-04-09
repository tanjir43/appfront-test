<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Contracts\Services\ProductServiceInterface;

class UpdateProductCommand extends Command
{
    protected $signature = 'product:update {id} {--name=} {--description=} {--price=}';

    protected $description = 'Update a product with the specified details';

    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        parent::__construct();
        $this->productService = $productService;
    }

    public function handle(): int
    {
        $id = $this->argument('id');
        $product = $this->productService->getProductById($id);

        if (!$product) {
            $this->error("Product with ID {$id} not found.");
            return 1;
        }

        $data = $this->collectData();

        if (empty($data)) {
            $this->info("No changes provided. Product remains unchanged.");
            return 0;
        }

        if (!$this->validateData($data)) {
            return 1;
        }

        try {
            $this->productService->updateProductFromCommand($id, $data);
            $this->info("Product updated successfully.");

            if (isset($data['price'])) {
                $this->info("Price updated to: {$data['price']}");
            }

            return 0;
        } catch (Exception $e) {
            $this->error("Failed to update product: {$e->getMessage()}");
            return 1;
        }
    }

    protected function collectData(): array
    {
        $data = [];

        if ($this->option('name')) {
            $data['name'] = $this->option('name');
        }

        if ($this->option('description')) {
            $data['description'] = $this->option('description');
        }

        if ($this->option('price')) {
            $data['price'] = $this->option('price');
        }

        return $data;
    }

    protected function validateData(array $data): bool
    {
        $validator = Validator::make($data, [
            'name'          => 'sometimes|required|min:3',
            'description'   => 'sometimes|nullable',
            'price'         => 'sometimes|required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return false;
        }

        return true;
    }
}
