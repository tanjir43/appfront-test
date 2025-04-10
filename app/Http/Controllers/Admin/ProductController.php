<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Contracts\Services\ProductServiceInterface;

class ProductController extends Controller
{
    protected ProductServiceInterface $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(): View
    {
        $products = $this->productService->getAllProducts();

        return view('admin.products', compact('products'));
    }

    public function create(): View
    {
        return view('admin.add_product');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();
        $image = $request->hasFile('image') ? $request->file('image') : null;

        $this->productService->createProduct($validatedData, $image);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Product added successfully');
    }

    public function edit(int $id): View
    {
        $product = $this->productService->getProductById($id);

        return view('admin.edit_product', compact('product'));
    }

    public function update(UpdateProductRequest $request, int $id): RedirectResponse
    {
        $validatedData = $request->validated();
        $image = $request->hasFile('image') ? $request->file('image') : null;

        $this->productService->updateProduct($id, $validatedData, $image);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Product updated successfully');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->productService->deleteProduct($id);

        return redirect()
            ->route('admin.products')
            ->with('success', 'Product deleted successfully');
    }
}
